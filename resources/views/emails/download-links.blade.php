<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>روابط التحميل - {{ $app_name ?? 'شراكة الأعمال' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', 'Cairo', 'Tajawal', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            direction: rtl;
            min-height: 100vh;
        }

        .email-wrapper {
            padding: 40px 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 650px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            overflow: hidden;
            border: 1px solid #e8ecef;
        }

        .header {
            background: linear-gradient(135deg, #c41e3a 0%, #8b1538 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .logo {
            max-width: 180px;
            height: auto;
            margin-bottom: 20px;
            filter: brightness(0) invert(1);
        }

        .header-content {
            position: relative;
            z-index: 1;
        }

        .header-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .header-subtitle {
            font-size: 18px;
            opacity: 0.9;
            font-weight: 300;
        }

        .content {
            padding: 40px 35px;
            line-height: 1.8;
        }

        .greeting {
            font-size: 20px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .intro-text {
            font-size: 16px;
            color: #5a6c7d;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .download-item {
            background: linear-gradient(145deg, #ffffff 0%, #f8f9fc 100%);
            border: 2px solid #e3e8ee;
            border-radius: 15px;
            padding: 25px;
            margin: 20px 0;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .download-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.12);
        }

        .product-title {
            font-size: 18px;
            font-weight: 700;
            color: #c41e3a;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .product-title::before {
            content: '📦';
            margin-left: 10px;
            font-size: 20px;
        }

        .product-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .detail-item {
            background: #f0f4f8;
            padding: 12px 15px;
            border-radius: 8px;
            border-right: 4px solid #c41e3a;
        }

        .detail-label {
            font-size: 12px;
            color: #718096;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 14px;
            color: #2d3748;
            font-weight: 600;
            margin-top: 4px;
        }

        .download-btn {
            background: linear-gradient(135deg, #c41e3a 0%, #8b1538 100%);
            color: #ffffff !important;
            padding: 15px 35px;
            text-decoration: none !important;
            border-radius: 10px;
            display: inline-block;
            margin: 15px 0;
            font-size: 16px;
            font-weight: 700;
            text-align: center;
            box-shadow: 0 8px 20px rgba(196, 30, 58, 0.3);
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: none;
            outline: none;
        }

        .download-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(196, 30, 58, 0.4);
            color: #ffffff !important;
            text-decoration: none !important;
        }

        .download-btn:visited {
            color: #ffffff !important;
            text-decoration: none !important;
        }

        .download-btn:active {
            color: #ffffff !important;
            text-decoration: none !important;
        }

        .info-box {
            background: linear-gradient(135deg, #fff7e6 0%, #fef3e2 100%);
            border: 2px solid #f6ad55;
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
            position: relative;
        }

        .info-box::before {
            content: '💡';
            position: absolute;
            top: -10px;
            right: 20px;
            background: #f6ad55;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .info-title {
            font-size: 18px;
            font-weight: 700;
            color: #744210;
            margin-bottom: 15px;
            margin-top: 10px;
        }

        .info-list {
            list-style: none;
            padding: 0;
        }

        .info-list li {
            padding: 8px 0;
            color: #744210;
            font-weight: 500;
            position: relative;
            padding-right: 25px;
        }

        .info-list li::before {
            content: '✓';
            position: absolute;
            right: 0;
            color: #38a169;
            font-weight: bold;
            font-size: 16px;
        }

        .order-summary {
            background: linear-gradient(135deg, #f0fff4 0%, #e6fffa 100%);
            border: 2px solid #38a169;
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
        }

        .summary-title {
            font-size: 20px;
            font-weight: 700;
            color: #38a169;
            margin-bottom: 20px;
            text-align: center;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #c6f6d5;
        }

        .summary-item:last-child {
            border-bottom: none;
            font-weight: 700;
            font-size: 18px;
        }

        .summary-label {
            color: #2f855a;
            font-weight: 600;
        }

        .summary-value {
            color: #1a365d;
            font-weight: 600;
        }

        .footer {
            background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
            color: white;
            padding: 35px 30px;
            text-align: center;
        }

        .footer-logo {
            max-width: 120px;
            height: auto;
            margin-bottom: 20px;
            filter: brightness(0) invert(1);
        }

        .footer-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .footer-contact {
            font-size: 14px;
            opacity: 0.8;
            margin: 5px 0;
        }

        @media (max-width: 600px) {
            .email-wrapper {
                padding: 20px 10px;
            }

            .container {
                border-radius: 15px;
            }

            .header {
                padding: 30px 20px;
            }

            .content {
                padding: 30px 20px;
            }

            .product-details {
                grid-template-columns: 1fr;
            }

            .download-btn {
                display: block;
                text-align: center;
                margin: 20px 0;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="container">
            <div class="header">
                <div class="header-content">
                    <img src="{{ asset('logo.png') }}" alt="شعار الشركة" class="logo">
                    <h1 class="header-title">🎉 منتجاتك جاهزة للتحميل!</h1>
                    <p class="header-subtitle">يمكنك تحميل جميع الحقيبهات من هنا</p>
                </div>
            </div>

            <div class="content">
                <h2 class="greeting">مرحباً {{ $user->name }}،</h2>

                <p class="intro-text">
                    نشكرك لاختيارك خدماتنا! تم تأكيد دفعتك بنجاح ويمكنك الآن تحميل الحقيبهات التي قمت بشرائها من الروابط المُؤمّنة أدناه:
                </p>

                @foreach($downloadTokens as $index => $token)
                <div class="download-item">
                    <h3 class="product-title">{{ $products[$index]->name ?? 'منتج رقمي' }}</h3>

                    <div class="product-details">
                        <div class="detail-item">
                            <div class="detail-label">عدد التحميلات المسموح</div>
                            <div class="detail-value">3 مرات</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">ينتهي في</div>
                            <div class="detail-value">{{ $expires_at->format('Y/m/d') }}</div>
                        </div>
                    </div>

                    <div style="text-align: center;">
                        <a href="{{ $token->download_url }}" class="download-btn">
                            📥 تحميل الحقيبه الآن
                        </a>
                    </div>
                </div>
                @endforeach

                <div class="info-box">
                    <h4 class="info-title">ملاحظات مهمة</h4>
                    <ul class="info-list">
                        <li>كل رابط تحميل له عدد محدود من مرات الاستخدام</li>
                        <li>الروابط لها تاريخ انتهاء صلاحية محدد</li>
                        <li>احفظ ملفاتك في مكان آمن بعد التحميل</li>
                        <li>لا تشارك روابط التحميل مع أشخاص آخرين</li>
                        <li>في حالة وجود أي مشكلة، تواصل معنا فوراً</li>
                    </ul>
                </div>
            </div>

            <div class="footer">
                <img src="{{ asset('logo.png') }}" alt="شعار الشركة" class="footer-logo">
                <h3 class="footer-title">B2B Partnership</h3>
                <p class="footer-contact">نحن هنا لخدمتك على مدار الساعة</p>
                <p class="footer-contact">للدعم الفني: support@b2bpartnership.com</p>
            </div>
        </div>
    </div>
</body>
</html>
