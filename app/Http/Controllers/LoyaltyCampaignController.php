<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Container;
use App\Models\LoyaltyCard;
use App\Models\LoyaltyCardRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\LoyaltyCampaign;
use App\Models\LoyaltyContainer;
use App\Jobs\SendWhatsAppMessageJob;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LoyaltyCampaignExport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Console\View\Components\Task;

class LoyaltyCampaignController extends Controller
{
    public function index(Request $request)
    {
        $campaigns = LoyaltyCampaign::with(['loyaltyCard', 'loyaltyContainer']);

        // فلترة حسب نوع البطاقة
        if ($request->filled('card_type')) {
            $campaigns->byCardType($request->card_type);
        }

        // فلترة حسب حاوية الولاء
        if ($request->filled('loyalty_container_id')) {
            $campaigns->where('loyalty_container_id', $request->loyalty_container_id);
        }

        // فلترة حسب تاريخ الإنشاء
        if ($request->filled('created_at_sort')) {
            $campaigns->orderBy('created_at', $request->created_at_sort);
        }

        // فلترة حسب تاريخ بداية الحملة
        if ($request->filled('start_date_sort')) {
            $campaigns->orderBy('start_date', $request->start_date_sort);
        }

        // البحث في اسم الحملة أو اسم المدير
        if ($request->filled('search_campaign')) {
            $search = $request->input('search_campaign');
            $campaigns->where(function($q) use ($search) {
                $q->where('campaign_name', 'LIKE', "%{$search}%")
                  ->orWhere('manager_name', 'LIKE', "%{$search}%");
            });
        }

        // البحث العام في اسم الحملة (للتوافق مع البحث الموجود)
        if ($request->filled('query')) {
            $search = $request->input('query');
            $campaigns->where('campaign_name', 'LIKE', "%{$search}%")
                ->orWhereHas('loyaltyCard', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
        }

        $campaigns = $campaigns->orderBy('id', 'desc')->paginate(10);
        $loyaltyCards = LoyaltyCard::all();
        $loyaltyContainers = LoyaltyContainer::where('is_active', true)->get();

        // إحصائيات حملات الولاء
        $statistics = [
            'total_campaigns' => LoyaltyCampaign::count(),
            'active_campaigns' => LoyaltyCampaign::where('start_date', '<=', now())
                ->where('end_date', '>=', now())->count(),
            'upcoming_campaigns' => LoyaltyCampaign::where('start_date', '>', now())->count(),
            'expired_campaigns' => LoyaltyCampaign::where('end_date', '<', now())->count(),
            'total_requests' => LoyaltyCardRequest::count(),
            'pending_requests' => LoyaltyCardRequest::where('status', 'pending')->count(),
            'approved_requests' => LoyaltyCardRequest::where('status', 'approved')->count(),
            'rejected_requests' => LoyaltyCardRequest::where('status', 'rejected')->count(),
            'total_customers' => Customer::count(),
            'customers_in_loyalty' => Customer::whereNotNull('loyalty_container_id')->count(),
            'total_loyalty_containers' => LoyaltyContainer::where('is_active', true)->count(),
            'total_loyalty_cards' => LoyaltyCard::where('is_active', true)->count(),
            'requests_this_month' => LoyaltyCardRequest::whereMonth('created_at', now()->month)->count(),
            'requests_this_week' => LoyaltyCardRequest::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'requests_today' => LoyaltyCardRequest::whereDate('created_at', now()->toDateString())->count(),
        ];

        return view('backend.pages.loyalty_campaigns.index', compact('campaigns', 'loyaltyCards', 'loyaltyContainers', 'statistics'));
    }

    public function create()
    {
        $loyaltyCards = LoyaltyCard::where('is_active', true)->get();
        $loyaltyContainers = LoyaltyContainer::where('is_active', true)->get();

        return view('backend.pages.loyalty_campaigns.create', compact('loyaltyCards', 'loyaltyContainers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loyalty_card_id' => 'required|exists:loyalty_cards,id',
            'loyalty_container_id' => 'required|exists:loyalty_containers,id',
            'campaign_name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'manager_name' => 'required|string|max:255',
            'sending_method' => 'required|in:whatsapp,email',
            'whatsapp_template_id' => 'nullable|string|max:255',
            'whatsapp_image_url' => 'nullable|url',
            'email_template' => 'nullable|string',
            'additional_terms' => 'nullable|string',
            'page_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'main_text' => 'nullable|string',
            'sub_text' => 'nullable|string',
            'after_form_text' => 'nullable|string',
            'redirect_url' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            toast($validator->errors()->first(), 'error');
            return redirect()->back();
        }

        $data = $validator->validated();

        if ($image = $request->file('page_logo')){
            $path = 'images/loyalty_campaigns/';
            $filename = time().$image->getClientOriginalName();
            $image->move($path, $filename);
            $data['page_logo'] = $path.$filename;
        }

        $data['slug'] = Str::slug($data['campaign_name']).'-'.time();
        LoyaltyCampaign::create($data);
        toast('تم الإضافة بنجاح', 'success');
        return redirect()->route('admin.loyalty_campaigns.index');
    }

    public function show(LoyaltyCampaign $loyaltyCampaign)
    {
        $loyaltyCampaign->load(['loyaltyCard', 'loyaltyContainer', 'customers']);
        return view('backend.pages.loyalty_campaigns.show', compact('loyaltyCampaign'));
    }

    public function edit(LoyaltyCampaign $loyaltyCampaign)
    {
        $loyaltyCards = LoyaltyCard::where('is_active', true)->get();
        $loyaltyContainers = LoyaltyContainer::where('is_active', true)->get();

        return view('backend.pages.loyalty_campaigns.edit', compact('loyaltyCampaign', 'loyaltyCards', 'loyaltyContainers'));
    }

    public function update(Request $request, LoyaltyCampaign $loyaltyCampaign)
    {
        $validator = Validator::make($request->all(), [
            'loyalty_card_id' => 'required|exists:loyalty_cards,id',
            'loyalty_container_id' => 'required|exists:loyalty_containers,id',
            'campaign_name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'manager_name' => 'required|string|max:255',
            'sending_method' => 'required|in:whatsapp,email',
            'whatsapp_template_id' => 'nullable|string|max:255',
            'whatsapp_image_url' => 'nullable|url',
            'email_template' => 'nullable|string',
            'additional_terms' => 'nullable|string',
            'page_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'main_text' => 'nullable|string',
            'sub_text' => 'nullable|string',
            'after_form_text' => 'nullable|string',
            'redirect_url' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        if ($image = $request->file('page_logo')){
            $path = 'images/loyalty_campaigns/';
            $filename = time().$image->getClientOriginalName();
            $image->move($path, $filename);
            $data['page_logo'] = $path.$filename;
        }


        $loyaltyCampaign->update($data);

        toast('تم التعديل بنجاح', 'success');
        return redirect()->route('admin.loyalty_campaigns.index');
    }

    public function destroy(LoyaltyCampaign $loyaltyCampaign)
    {
        $loyaltyCampaign->delete();
        toast('تم الحذف بنجاح', 'success');
        return redirect()->back();
    }

    public function toggleStatus(LoyaltyCampaign $loyaltyCampaign)
    {
        $loyaltyCampaign->update(['is_active' => !$loyaltyCampaign->is_active]);

        return response()->json([
            'message' => $loyaltyCampaign->is_active ? trans('back.campaign_activated') : trans('back.campaign_deactivated'),
            'status' => $loyaltyCampaign->is_active
        ]);
    }

    public function customers(LoyaltyCampaign $loyaltyCampaign)
    {
        $customers = $loyaltyCampaign->loyaltyContainer->customers()->paginate(10);
        return view('backend.pages.loyalty_campaigns.customers', compact('loyaltyCampaign', 'customers'));
    }

    public function sendCampaign(Request $request, LoyaltyCampaign $loyaltyCampaign)
    {
        // إذا كان طلب معاينة
        if ($request->has('preview') && $request->preview) {
            $customerIds = $request->input('customer_ids', []);
            $customers = $loyaltyCampaign->loyaltyContainer->customers()->whereIn('id', $customerIds)->get();

            return view('backend.pages.loyalty_campaigns.preview', compact('loyaltyCampaign', 'customers'));
        }

        $customers = $loyaltyCampaign->loyaltyContainer ? $loyaltyCampaign->loyaltyContainer->customers : collect();
        return view('backend.pages.loyalty_campaigns.send', compact('loyaltyCampaign', 'customers'));
    }

    public function sendToCustomers(Request $request, LoyaltyCampaign $loyaltyCampaign)
    {

        $customerIds = $request->input('customer_ids', []);
        $customers = $loyaltyCampaign->loyaltyContainer->customers()->whereIn('id', $customerIds)->get();

        // إرسال الحملة للعملاء المحددين عبر الطابور (Queue)
        foreach ($customers as $customer) {
            if ($loyaltyCampaign->sending_method === 'whatsapp') {
                // جدولة إرسال رسالة واتساب في الطابور
                dispatch(new SendWhatsAppMessageJob($customer, $loyaltyCampaign));
            } else {
                // إرسال عبر البريد الإلكتروني
                $this->sendEmailMessage($customer, $loyaltyCampaign);
            }
        }

        return response()->json(['message' => trans('back.campaign_sent_successfully')]);
    }

    public function export(Request $request)
    {
        $campaignIds = $request->input('campaign_ids', []);

        if (empty($campaignIds)) {
            return response()->json(['error' => trans('back.please_select_campaigns')], 400);
        }

        $campaigns = LoyaltyCampaign::whereIn('id', $campaignIds)->get();

        // تصدير كل حملة في ملف منفصل
        foreach ($campaigns as $campaign) {
            $filename = 'loyalty_campaign_' . $campaign->campaign_name . '_' . date('Y-m-d_H-i-s') . '.xlsx';
            Excel::store(new LoyaltyCampaignExport($campaign), 'exports/' . $filename);
        }

        return response()->json(['message' => trans('back.campaigns_exported_successfully')]);
    }

    private function sendEmailMessage($customer, $loyaltyCampaign)
    {
        // تنفيذ إرسال البريد الإلكتروني
        // يمكن استخدام Laravel Mail هنا
    }

    public function landingPage($campaignId)
    {
        $campaign = LoyaltyCampaign::where('slug', $campaignId)->first();
        return view('frontend.pages.loyalty_campaign_landing', compact('campaign'));
    }

    public function successPage($campaignId)
    {
        $campaign = LoyaltyCampaign::where('slug', $campaignId)->first();
        return view('frontend.pages.loyalty_campaign_success', compact('campaign'));
    }

    public function showTestWhatsApp(LoyaltyCampaign $loyaltyCampaign)
    {
        return view('backend.pages.loyalty_campaigns.test_whatsapp', compact('loyaltyCampaign'));
    }

    public function testWhatsApp(Request $request, LoyaltyCampaign $loyaltyCampaign)
    {
        $phone = $request->input('phone');
        $templateID = $loyaltyCampaign->whatsapp_template_id ?? $loyaltyCampaign->id_template ?? null;
        $imageUrl = $loyaltyCampaign->whatsapp_image_url ?? null;

        if (!$phone || !$templateID) {
            return response()->json([
                'success' => false,
                'message' => 'Phone number and template ID are required'
            ], 400);
        }

        // استخدام رابط عام بدلاً من الرابط المحلي
        $landingPageUrl = $loyaltyCampaign->campaign_name;

        $variables = [];
        if ($imageUrl) $variables[] = $imageUrl;
        if ($landingPageUrl) $variables[] = $landingPageUrl;

        $requestData = [
            'templateID' => $templateID,
            'userPhoneNumber' => $phone,
            'variables' => $variables,
            'metadata' => [
                'invoiceNumber' => now()->timestamp
            ]
        ];

        try {
            // Test internet connectivity first
            $testResponse = Http::timeout(10)->get('https://httpbin.org/get');
            if (!$testResponse->successful()) {
                throw new \Exception('Internet connectivity test failed');
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer 24143221ba80f4af6240c53710769f6288633bdaa6e14725edb563ca65fca887',
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://ob.bab.solutions/v1/wa/messages', $requestData);

            return response()->json([
                'success' => $response->successful(),
                'status' => $response->status(),
                'body' => $response->body(),
                'request_data' => $requestData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'request_data' => $requestData
            ], 500);
        }
    }

    private function getLandingPageUrl($campaignId)
    {
        // إذا كنا في بيئة الإنتاج، استخدم الرابط العام
        if (app()->environment('production')) {
            return 'https://aldaham.com/loyalty-campaign/' . $campaignId;
        }

        // إذا كنا في بيئة التطوير، استخدم رابط محلي صالح
        return 'https://aldaham.com/loyalty-campaign/' . $campaignId;
    }
}
