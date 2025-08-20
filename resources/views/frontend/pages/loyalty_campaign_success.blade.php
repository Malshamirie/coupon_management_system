<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>تم إرسال الطلب بنجاح - {{ $campaign->campaign_name }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <style>
    body {
      font-family: 'Figtree', sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      margin: 0;
      padding: 0;
    }

    .success-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .success-card {
      background: white;
      border-radius: 25px;
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
      overflow: hidden;
      max-width: 500px;
      width: 100%;
      text-align: center;
      position: relative;
    }

    .success-header {
      background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
      color: white;
      padding: 40px 30px;
      position: relative;
    }

    .success-icon {
      width: 100px;
      height: 100px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      font-size: 50px;
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7);
      }
      70% {
        transform: scale(1.05);
        box-shadow: 0 0 0 10px rgba(255, 255, 255, 0);
      }
      100% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
      }
    }

    .success-body {
      padding: 40px 30px;
    }

    .success-title {
      color: #28a745;
      font-size: 28px;
      font-weight: 600;
      margin-bottom: 15px;
    }

    .success-message {
      color: #6c757d;
      font-size: 16px;
      line-height: 1.6;
      margin-bottom: 30px;
    }

    .campaign-info {
      background: #f8f9fa;
      border-radius: 15px;
      padding: 20px;
      margin-bottom: 30px;
    }

    .campaign-name {
      font-weight: 600;
      color: #495057;
      margin-bottom: 5px;
    }

    .campaign-card {
      color: #6c757d;
      font-size: 14px;
    }

    .btn-home {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: none;
      border-radius: 15px;
      padding: 15px 30px;
      font-size: 16px;
      font-weight: 600;
      color: white;
      text-decoration: none;
      display: inline-block;
      transition: all 0.3s ease;
    }

    .btn-home:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
      color: white;
      text-decoration: none;
    }

    .success-footer {
      background: #f8f9fa;
      padding: 20px 30px;
      color: #6c757d;
      font-size: 14px;
    }

    .confetti {
      position: absolute;
      width: 10px;
      height: 10px;
      background: #ffd700;
      animation: confetti-fall 3s linear infinite;
    }

    @keyframes confetti-fall {
      0% {
        transform: translateY(-100px) rotate(0deg);
        opacity: 1;
      }
      100% {
        transform: translateY(100vh) rotate(360deg);
        opacity: 0;
      }
    }

    .floating-elements {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      overflow: hidden;
    }
  </style>
</head>

<body dir="rtl">
  <div class="success-container">
    <div class="success-card">
      <!-- Floating Elements -->
      <div class="floating-elements">
        <div class="confetti" style="left: 10%; animation-delay: 0s;"></div>
        <div class="confetti" style="left: 20%; animation-delay: 0.5s;"></div>
        <div class="confetti" style="left: 30%; animation-delay: 1s;"></div>
        <div class="confetti" style="left: 40%; animation-delay: 1.5s;"></div>
        <div class="confetti" style="left: 50%; animation-delay: 2s;"></div>
        <div class="confetti" style="left: 60%; animation-delay: 0.3s;"></div>
        <div class="confetti" style="left: 70%; animation-delay: 0.8s;"></div>
        <div class="confetti" style="left: 80%; animation-delay: 1.3s;"></div>
        <div class="confetti" style="left: 90%; animation-delay: 1.8s;"></div>
      </div>

      <!-- Header -->
      <div class="success-header">
        <div class="success-icon">
          <i class="fas fa-check"></i>
        </div>
        <h2>تم إرسال طلبك بنجاح! 🎉</h2>
      </div>

      <!-- Body -->
      <div class="success-body">
        <div class="success-title">
          <i class="fas fa-clock me-2"></i>
          تم استلام طلبك بنجاح! ⏰
        </div>
        
        <div class="success-message">
          شكراً لك! تم استلام طلبك وسيتم مراجعته من قبل فريقنا المختص. 
          سنتواصل معك قريباً عبر الهاتف أو الرسائل النصية.
          <br><br>
          <strong>انتظر حتى إشعار آخر</strong> 📱
        </div>

        <div class="campaign-info">
          <div class="campaign-name">{{ $campaign->campaign_name }}</div>
          <div class="campaign-card">{{ $campaign->card_name }}</div>
        </div>

        <a href="{{ route('home') }}" class="btn-home">
          <i class="fas fa-home me-2"></i>
          العودة للصفحة الرئيسية
        </a>
      </div>

      <!-- Footer -->
      <div class="success-footer">
        <p class="mb-0">
          <i class="fas fa-heart text-danger me-1"></i>
          شكراً لثقتك بنا {{ App\Models\Setting::first()->company_name??'الدهام' }}
        </p>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
