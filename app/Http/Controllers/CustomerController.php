<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Container;
use Illuminate\Http\Request;
use App\Imports\CustomersImport;
use App\Models\LoyaltyContainer;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $queryBuilder = Customer::with('loyaltyContainer');

        // البحث في اسم العميل أو رقم الهاتف أو البريد الإلكتروني
        if ($request->filled('query')) {
            $search = $request->input('query');
            $queryBuilder->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('phone_number', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // فلترة حسب حاوية الولاء
        if ($request->filled('loyalty_container_id')) {
            $queryBuilder->where('loyalty_container_id', $request->loyalty_container_id);
        }

        $customers = $queryBuilder->orderBy('id', 'desc')->paginate(10);
        $loyaltyContainers = LoyaltyContainer::where('is_active', true)->get();

        $statistics = [
            
            'total_customers' => Customer::count(),
            'customers_in_loyalty' => Customer::whereNotNull('loyalty_container_id')->count(),

        ];
        return view('backend.pages.customers.index', compact('customers', 'loyaltyContainers', 'statistics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:customers,phone',
            'email' => 'nullable|email|max:255|unique:customers,email',
            'address' => 'nullable|string',
            'loyalty_container_id' => 'required|exists:loyalty_containers,id'
        ]);

        Customer::create($request->all());

        toast('تم الإضافة بنجاح', 'success');
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:customers,phone,' . $id,
            'email' => 'nullable|email|max:255|unique:customers,email,' . $id,
            'address' => 'nullable|string',
            'loyalty_container_id' => 'required|exists:loyalty_containers,id'
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        toast('تم التعديل بنجاح', 'success');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        toast('تم الحذف بنجاح', 'success');
        return redirect()->back();
    }

    public function debugImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv,txt',
        ]);

        try {
            // قراءة الملف بدون معالجة
            $data = Excel::toArray([], $request->file('file'));
            
            if (empty($data) || empty($data[0])) {
                return response()->json([
                    'error' => 'الملف فارغ أو لا يمكن قراءته'
                ]);
            }

            $sheet = $data[0];
            $headers = $sheet[0] ?? [];
            $firstRow = $sheet[1] ?? [];
            $secondRow = $sheet[2] ?? [];
            $thirdRow = $sheet[3] ?? [];

            // فحص العناوين
            $headerAnalysis = [];
            foreach ($headers as $index => $header) {
                $headerAnalysis[] = [
                    'index' => $index,
                    'header' => $header,
                    'trimmed' => trim($header),
                    'lowercase' => strtolower(trim($header))
                ];
            }

            return response()->json([
                'success' => true,
                'total_rows' => count($sheet),
                'headers' => $headers,
                'header_analysis' => $headerAnalysis,
                'first_row' => $firstRow,
                'second_row' => $secondRow,
                'third_row' => $thirdRow,
                'file_info' => [
                    'original_name' => $request->file('file')->getClientOriginalName(),
                    'size' => $request->file('file')->getSize(),
                    'mime_type' => $request->file('file')->getMimeType()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'خطأ في قراءة الملف: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    private function getImportRecommendations($headerAnalysis)
    {
        $recommendations = [];
        
        $hasName = false;
        $hasPhone = false;
        
        foreach ($headerAnalysis as $header) {
            if ($header['is_name']) $hasName = true;
            if ($header['is_phone']) $hasPhone = true;
        }
        
        if (!$hasName) {
            $recommendations[] = 'تحذير: لم يتم العثور على عمود للاسم. تأكد من وجود عمود باسم "name" أو "الاسم"';
        }
        
        if (!$hasPhone) {
            $recommendations[] = 'تحذير: لم يتم العثور على عمود لرقم الهاتف. تأكد من وجود عمود باسم "phone" أو "رقم_الهاتف"';
        }
        
        if (empty($recommendations)) {
            $recommendations[] = 'الملف يبدو صحيحاً. يمكنك المتابعة مع الاستيراد.';
        }
        
        return $recommendations;
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv,txt',
            'loyalty_container_id' => 'required|exists:loyalty_containers,id',
            'file_type' => 'required|in:with_headers,without_headers'
        ]);

        try {
            // فحص الملف أولاً
            $data = Excel::toArray([], $request->file('file'));
            
            if (empty($data) || empty($data[0])) {
                toast('الملف فارغ أو لا يمكن قراءته', 'error');
                return redirect()->back();
            }

            $sheet = $data[0];
            $headers = $sheet[0] ?? [];
            
            // طباعة معلومات التشخيص في السجلات
            \Log::info('Import Debug Info', [
                'headers' => $headers,
                'first_row' => $sheet[1] ?? [],
                'total_rows' => count($sheet),
                'file_type' => $request->file_type
            ]);

            $hasHeaders = ($request->file_type === 'with_headers');
            
            // إعادة تعيين مؤشر الملف
            $request->file('file')->reset();
            
            Excel::import(new CustomersImport($request->loyalty_container_id, $hasHeaders), $request->file('file'));
            toast('تم استيراد العملاء بنجاح', 'success');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            
            foreach ($failures as $failure) {
                $errorMessages[] = 'الصف ' . ($failure->row() - 1) . ': ' . implode(', ', $failure->errors());
            }
            
            toast('أخطاء في الاستيراد: ' . implode(' | ', $errorMessages), 'error');
        } catch (\Exception $e) {
            \Log::error('Import Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            toast('حدث خطأ أثناء الاستيراد: ' . $e->getMessage(), 'error');
        }

        return redirect()->back();
    }

    public function export()
    {
        return Excel::download(new \App\Exports\CustomersExport, 'customers.xlsx');
    }
} 