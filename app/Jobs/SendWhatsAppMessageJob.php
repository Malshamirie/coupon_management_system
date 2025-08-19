<?php

namespace App\Jobs;

use App\Models\LoyaltyCampaignRecipient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWhatsAppMessageJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $customer;
  protected $loyaltyCampaign;

  public function __construct($customer, $loyaltyCampaign)
  {
    $this->customer = $customer;
    $this->loyaltyCampaign = $loyaltyCampaign;
  }

  private function getLandingPageUrl()
  {
    // إذا كنا في بيئة الإنتاج، استخدم الرابط العام
    if (app()->environment('production')) {
      return 'https://aldaham.com/loyalty-campaign/' . $this->loyaltyCampaign->id;
    }

    // إذا كنا في بيئة التطوير، استخدم رابط محلي صالح
    return 'https://aldaham.com/loyalty-campaign/' . $this->loyaltyCampaign->id;
  }

  public function handle()
  {
    $phone = $this->customer->phone;
    $templateID = $this->loyaltyCampaign->whatsapp_template_id ?? $this->loyaltyCampaign->id_template ?? null;
    $imageUrl = $this->loyaltyCampaign->whatsapp_image_url ?? null;

    // استخدام رابط عام بدلاً من الرابط المحلي
    $landingPageUrl = '';
    // $landingPageUrl = $this->getLandingPageUrl();

    // Log the data being sent
    Log::info('WhatsApp Job Data:', [
      'phone' => $phone,
      'templateID' => $templateID,
      'imageUrl' => $imageUrl,
      'campaign_id' => $this->loyaltyCampaign->id,
      'customer_id' => $this->customer->id
    ]);


    // Test internet connectivity first
    try {
      $testResponse = Http::timeout(10)->get('https://httpbin.org/get');
      if (!$testResponse->successful()) {
        throw new \Exception('Internet connectivity test failed');
      }
      Log::info('Internet connectivity test passed');
    } catch (\Exception $e) {
      Log::error('Internet connectivity test failed: ' . $e->getMessage());
      throw $e;
    }

    try {
      $requestData = [
        'templateID' => $templateID,
        'userPhoneNumber' => $phone,
        'variables' => [
          $imageUrl,
          $landingPageUrl
        ],
        'metadata' => [
          'invoiceNumber' => now()->timestamp
        ]
      ];

      // Log the request data
      Log::info('WhatsApp API Request:', [
        'url' => 'https://ob.bab.solutions/v1/wa/messages',
        'data' => $requestData
      ]);

      $response = Http::withHeaders([
        'Authorization' => 'Bearer 24143221ba80f4af6240c53710769f6288633bdaa6e14725edb563ca65fca887',
        'Content-Type' => 'application/json',
      ])->timeout(30)->post('https://ob.bab.solutions/v1/wa/messages', $requestData);

      // Log the response
      Log::info('WhatsApp API Response:', [
        'status' => $response->status(),
        'body' => $response->body(),
        'successful' => $response->successful()
      ]);

      // حفظ أو تحديث بيانات المستقبل
      $recipient = LoyaltyCampaignRecipient::updateOrCreate(
        [
          'loyalty_campaign_id' => $this->loyaltyCampaign->id,
          'customer_id' => $this->customer->id,
          'phone_number' => $phone
        ],
        [
          'status' => $response->successful() ? 'delivered' : 'failed',
          'message_id' => $response->successful() ? ($response->json()['message_id'] ?? null) : null,
          'error_message' => $response->successful() ? null : $response->body(),
          'delivered_at' => $response->successful() ? now() : null,
          'failed_at' => $response->successful() ? null : now(),
          'sent_at' => now()
        ]
      );

      if (!$response->successful()) {
        Log::error('WhatsApp Send Error: ' . $response->body());
      }
    } catch (\Exception $e) {
      // Log detailed exception information
      Log::error('WhatsApp Send Exception:', [
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString(),
        'phone' => $phone,
        'campaign_id' => $this->loyaltyCampaign->id
      ]);

      // حفظ الخطأ في قاعدة البيانات
      LoyaltyCampaignRecipient::updateOrCreate(
        [
          'loyalty_campaign_id' => $this->loyaltyCampaign->id,
          'customer_id' => $this->customer->id,
          'phone_number' => $phone
        ],
        [
          'status' => 'failed',
          'error_message' => $e->getMessage(),
          'failed_at' => now(),
          'sent_at' => now()
        ]
      );
    }
  }
}
