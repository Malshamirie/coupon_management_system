<?php

namespace App\Http\Controllers;

use App\Jobs\SendWhatsAppMessageJob;
use App\Models\LoyaltyCampaign;
use App\Models\LoyaltyCampaignRecipient;
use Illuminate\Http\Request;

class LoyaltyCampaignRecipientController extends Controller
{
  public function index(Request $request)
  {
    $query = LoyaltyCampaignRecipient::with(['loyaltyCampaign', 'customer']);

    // فلترة حسب الحملة
    if ($request->filled('campaign_id')) {
      $query->byCampaign($request->campaign_id);
    }

    // فلترة حسب الحالة
    if ($request->filled('status')) {
      $query->byStatus($request->status);
    }

    // فلترة حسب رقم الهاتف
    if ($request->filled('phone')) {
      $query->where('phone_number', 'LIKE', '%' . $request->phone . '%');
    }

    // فلترة حسب التاريخ
    if ($request->filled('date_from')) {
      $query->whereDate('sent_at', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
      $query->whereDate('sent_at', '<=', $request->date_to);
    }

    $recipients = $query->orderBy('sent_at', 'desc')->paginate(20);
    $campaigns = LoyaltyCampaign::all();

    return view('backend.pages.loyalty_campaign_recipients.index', compact('recipients', 'campaigns'));
  }

  public function retryFailed(Request $request)
  {
    $recipientIds = $request->input('recipient_ids', []);

    if (empty($recipientIds)) {
      return response()->json(['error' => 'لم يتم تحديد أي مستلم لإعادة المحاولة'], 400);
    }

    $recipients = LoyaltyCampaignRecipient::whereIn('id', $recipientIds)
      ->where('status', 'failed')
      ->with(['customer', 'loyaltyCampaign'])
      ->get();

    $retryCount = 0;
    foreach ($recipients as $recipient) {
      // إعادة جدولة الإرسال
      dispatch(new SendWhatsAppMessageJob($recipient->customer, $recipient->loyaltyCampaign));

      // تحديث عدد المحاولات
      $recipient->update([
        'retry_count' => $recipient->retry_count + 1,
        'status' => 'sent',
        'sent_at' => now(),
        'failed_at' => null,
        'error_message' => null
      ]);

      $retryCount++;
    }

    return response()->json([
      'message' => "تم إعادة إرسال {$retryCount} رسالة بنجاح",
      'retry_count' => $retryCount
    ]);
  }

  public function statistics()
  {
    $stats = [
      'total_sent' => LoyaltyCampaignRecipient::count(),
      'delivered' => LoyaltyCampaignRecipient::delivered()->count(),
      'failed' => LoyaltyCampaignRecipient::failed()->count(),
      'pending' => LoyaltyCampaignRecipient::sent()->count(),
      'delivery_rate' => 0
    ];

    if ($stats['total_sent'] > 0) {
      $stats['delivery_rate'] = round(($stats['delivered'] / $stats['total_sent']) * 100, 2);
    }

    return response()->json($stats);
  }
}
