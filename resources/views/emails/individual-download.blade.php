<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رابط التحميل - {{ $app_name ?? 'شراكة الأعمال' }}</title>
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

        .product-info {
            background: linear-gradient(145deg, #ffffff 0%, #f8f9fc 100%);
            border: 2px solid #e3e8ee;
            border-radius: 15px;
            padding: 30px;
            margin: 25px 0;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            text-align: center;
        }

        .product-title {
            font-size: 22px;
            font-weight: 700;
            color: #c41e3a;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-title::before {
            content: '📦';
            margin-left: 15px;
            font-size: 24px;
        }

        .product-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .detail-item {
            background: #f0f4f8;
            padding: 15px;
            border-radius: 10px;
            border-right: 4px solid #c41e3a;
        }

        .detail-label {
            font-size: 12px;
            color: #718096;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .detail-value {
            font-size: 16px;
            color: #2d3748;
            font-weight: 700;
        }

        .download-btn {
            background: linear-gradient(135deg, #c41e3a 0%, #8b1538 100%);
            color: #ffffff !important;
            padding: 18px 40px;
            text-decoration: none !important;
            border-radius: 12px;
            display: inline-block;
            margin: 20px 0;
            font-size: 18px;
            font-weight: 700;
            text-align: center;
            box-shadow: 0 10px 25px rgba(196, 30, 58, 0.3);
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            min-width: 250px;
            border: none;
            outline: none;
        }

        .download-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(196, 30, 58, 0.4);
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
        }        .download-btn::before {
            content: '📥';
            margin-left: 10px;
            font-size: 20px;
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
            content: '⚠️';
            position: absolute;
            top: -12px;
            right: 25px;
            background: #f6ad55;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .info-title {
            font-size: 18px;
            font-weight: 700;
            color: #744210;
            margin-bottom: 15px;
            margin-top: 15px;
        }

        .info-list {
            list-style: none;
            padding: 0;
        }

        .info-list li {
            padding: 10px 0;
            color: #744210;
            font-weight: 500;
            position: relative;
            padding-right: 30px;
            border-bottom: 1px solid #f0e68c;
        }

        .info-list li:last-child {
            border-bottom: none;
        }

        .info-list li::before {
            content: '🔒';
            position: absolute;
            right: 0;
            font-size: 16px;
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
        }        @media (max-width: 600px) {
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
                min-width: auto;
                margin: 25px 0;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="container">
            <!-- Header -->
            <div class="header">
                <div class="header-content">
                    <img src="{{ asset('logo.png') }}" alt="شعار الشركة" class="logo">
                    <h1 class="header-title">تحميل منتج جديد متاح</h1>
                    <p style="margin: 0; font-size: 16px; opacity: 0.9;">يمكنك الآن تحميل منتجك المطلوب بكل سهولة</p>
                </div>
            </div>

            <!-- Main Content -->
            <div class="content">
                <div class="greeting">
                    مرحباً {{ $user->name }}! 👋
                </div>

                <p class="intro-text">نحن سعداء لإبلاغك أن منتجك أصبح جاهزاً للتحميل الآن.</p>

                <div class="product-info">
                    <h3 class="product-title">{{ $product->name }}</h3>

                    <div class="product-details">
                        <div class="detail-item">
                            <div class="detail-label">عدد التحميلات المسموح</div>
                            <div class="detail-value">{{ $max_downloads }} مرات</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">ينتهي في</div>
                            <div class="detail-value">{{ $expires_at->format('Y-m-d H:i') }}</div>
                        </div>
                    </div>

                    <a href="{{ $download_url }}" class="download-btn">تحميل الحقيبه الآن</a>
                </div>

                <div class="info-box">
                    <h4 class="info-title">تعليمات مهمة حول التحميل:</h4>
                    <ul class="info-list">
                        <li>استخدم الرابط قبل انتهاء صلاحيته</li>
                        <li>عدد مرات التحميل محدود - استخدمه بحكمة</li>
                        <li>احفظ الملف في مكان آمن بعد التحميل</li>
                        <li>لا تشارك الرابط مع آخرين</li>
                    </ul>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <img src="{{ asset('logo.png') }}" alt="شعار الشركة" class="footer-logo">
                <div class="footer-title">B2B Partnership</div>
                <div class="footer-contact">نحن هنا لخدمتك على مدار الساعة</div>
                <div class="footer-contact">للدعم الفني: support@b2bpartnership.com</div>
            </div>
        </div>
    </div>
</body>
</html>
