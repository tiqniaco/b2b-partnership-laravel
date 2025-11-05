<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>روابط التحميل - {{ $app_name }}</title>
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
        .download-item {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin: 15px 0;
        }
        .download-btn {
            background: #28a745;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin: 10px 0;
        }
        .info-box {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
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
            <h1>🎉 تم تأكيد طلبك!</h1>
            <p>طلب رقم: #{{ $order->id }}</p>
        </div>

        <div class="content">
            <h2>مرحباً {{ $user->name }}،</h2>

            <p>تم تأكيد دفعتك بنجاح! يمكنك الآن تحميل المنتجات التي قمت بشرائها من الروابط أدناه:</p>

            @foreach($downloadTokens as $token)
            <div class="download-item">
                <h3>{{ $token->product->name }}</h3>
                <p><strong>رقم التوكن:</strong> {{ $token->token }}</p>
                <p><strong>عدد التحميلات المسموح:</strong> {{ $token->max_downloads }}</p>
                <p><strong>ينتهي في:</strong> {{ $token->expires_at->format('Y-m-d H:i') }}</p>

                <a href="{{ url('/download/' . $token->token) }}" class="download-btn">
                    📥 تحميل المنتج
                </a>
            </div>
            @endforeach

            <div class="info-box">
                <h4>📌 ملاحظات مهمة:</h4>
                <ul>
                    <li>كل رابط تحميل له عدد محدود من مرات الاستخدام</li>
                    <li>الروابط لها تاريخ انتهاء صلاحية</li>
                    <li>احفظ ملفاتك في مكان آمن بعد التحميل</li>
                    <li>في حالة وجود أي مشكلة، تواصل معنا فوراً</li>
                </ul>
            </div>

            <p><strong>المبلغ المدفوع:</strong> {{ $order->total }} {{ $order->currency ?? 'SAR' }}</p>
            <p><strong>تاريخ الطلب:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
        </div>

        <div class="footer">
            <p>شكراً لاختيارك {{ $app_name }}</p>
            <p>للدعم الفني: support@tiqnia.com</p>
        </div>
    </div>
</body>
</html>
