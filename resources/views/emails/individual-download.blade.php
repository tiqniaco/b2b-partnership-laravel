<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رابط التحميل - {{ $app_name }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
            direction: rtl;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .product-info {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin: 15px 0;
        }
        .download-btn {
            background: #28a745;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin: 15px 0;
            font-size: 16px;
            font-weight: bold;
        }
        .info-box {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
        }
        .footer {
            background: #343a40;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📄 رابط التحميل جاهز!</h1>
        </div>
        
        <div class="content">
            <h2>مرحباً {{ $user->name }}،</h2>
            
            <p>رابط تحميل المنتج الذي طلبته جاهز الآن:</p>
            
            <div class="product-info">
                <h3>{{ $product->name }}</h3>
                <p><strong>رقم التوكن:</strong> {{ $downloadToken->token }}</p>
                <p><strong>عدد التحميلات المسموح:</strong> {{ $max_downloads }}</p>
                <p><strong>ينتهي في:</strong> {{ $expires_at->format('Y-m-d H:i') }}</p>
                
                <div style="text-align: center;">
                    <a href="{{ $download_url }}" class="download-btn">
                        📥 تحميل المنتج الآن
                    </a>
                </div>
            </div>
            
            <div class="info-box">
                <h4>⚠️ تعليمات مهمة:</h4>
                <ul>
                    <li>استخدم الرابط قبل انتهاء صلاحيته</li>
                    <li>عدد مرات التحميل محدود - استخدمه بحكمة</li>
                    <li>احفظ الملف في مكان آمن بعد التحميل</li>
                    <li>لا تشارك الرابط مع آخرين</li>
                </ul>
            </div>
        </div>
        
        <div class="footer">
            <p>شكراً لاختيارك {{ $app_name }}</p>
            <p>للدعم الفني: support@tiqnia.com</p>
        </div>
    </div>
</body>
</html>