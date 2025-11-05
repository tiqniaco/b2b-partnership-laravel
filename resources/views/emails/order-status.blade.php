<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تحديث الطلب - {{ $app_name }}</title>
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
        .status-info {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin: 15px 0;
            text-align: center;
        }
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            color: white;
            font-weight: bold;
            display: inline-block;
            margin: 10px 0;
        }
        .status-paid { background: #28a745; }
        .status-processing { background: #ffc107; color: #212529; }
        .status-shipped { background: #17a2b8; }
        .status-delivered { background: #28a745; }
        .status-cancelled { background: #dc3545; }
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
            <h1>📦 تحديث حالة الطلب</h1>
            <p>طلب رقم: #{{ $order->id }}</p>
        </div>

        <div class="content">
            <h2>مرحباً {{ $user->name }}،</h2>

            <p>تم تحديث حالة طلبك:</p>

            <div class="status-info">
                <h3>الحالة الجديدة:</h3>
                <span class="status-badge status-{{ $status }}">
                    {{ $status_message }}
                </span>

                <div style="margin-top: 20px;">
                    <p><strong>رقم الطلب:</strong> #{{ $order->id }}</p>
                    <p><strong>المبلغ:</strong> {{ $order->total }} {{ $order->currency ?? 'SAR' }}</p>
                    <p><strong>تاريخ الطلب:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                    <p><strong>تاريخ التحديث:</strong> {{ now()->format('Y-m-d H:i') }}</p>
                </div>
            </div>

            @if($status === 'delivered')
            <div style="background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; padding: 15px; margin: 20px 0;">
                <h4>✅ تم التسليم بنجاح!</h4>
                <p>تم إرسال روابط التحميل إلى بريدك الإلكتروني. تحقق من صندوق الوارد أو البريد العشوائي.</p>
            </div>
            @elseif($status === 'cancelled')
            <div style="background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; padding: 15px; margin: 20px 0;">
                <h4>❌ تم إلغاء الطلب</h4>
                <p>إذا كنت قد دفعت، سيتم رد المبلغ خلال 3-5 أيام عمل.</p>
            </div>
            @endif
        </div>

        <div class="footer">
            <p>شكراً لاختيارك {{ $app_name }}</p>
            <p>للدعم الفني: support@tiqnia.com</p>
        </div>
    </div>
</body>
</html>
