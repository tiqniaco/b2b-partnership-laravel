# Download Token Configuration Guide

## 📋 Overview

تم إنشاء نظام إعدادات مرن للتحكم في روابط التحميل وعدد مرات التحميل المسموح بها.

## ⚙️ Configuration Files

### 1. `config/downloads.php`
الملف الرئيسي للإعدادات يحتوي على جميع المعاملات المطلوبة:

```php
return [
    'default_max_downloads' => env('DOWNLOAD_MAX_DOWNLOADS', 3),
    'min_downloads' => 1,
    'max_downloads' => env('DOWNLOAD_MAX_LIMIT', 10),
    'default_expiry_hours' => env('DOWNLOAD_EXPIRY_HOURS', 24),
    // ... المزيد من الإعدادات
];
```

### 2. `.env` Settings
```bash
# إعدادات التحميل الأساسية
DOWNLOAD_MAX_DOWNLOADS=3        # العدد الافتراضي للتحميلات
DOWNLOAD_MAX_LIMIT=10           # الحد الأقصى المسموح
DOWNLOAD_EXPIRY_HOURS=24        # مدة انتهاء الصلاحية بالساعات
DOWNLOAD_MAX_EXPIRY_HOURS=168   # أقصى مدة انتهاء صلاحية (أسبوع)

# إعدادات متقدمة
DOWNLOAD_ALLOW_UNLIMITED=false # السماح بتحميلات غير محدودة
DOWNLOAD_CLEANUP_DAYS=30       # تنظيف التوكنز المنتهية الصلاحية

# إعدادات الإشعارات
DOWNLOAD_SEND_EMAIL=true        # إرسال بريد إلكتروني
DOWNLOAD_EXPIRY_WARNING=true    # تحذير انتهاء الصلاحية
DOWNLOAD_WARNING_HOURS=2        # ساعات التحذير قبل انتهاء الصلاحية

# إعدادات الأمان
DOWNLOAD_IP_RESTRICTION=false   # تقييد عنوان IP
DOWNLOAD_USER_AGENT_CHECK=false # فحص User Agent
```

## 🛠️ Usage Examples

### إنشاء Token بالإعدادات الافتراضية:
```php
$token = $downloadService->createDownloadToken($user, $product);
// سيستخدم: 3 تحميلات، 24 ساعة صلاحية
```

### إنشاء Token بإعدادات مخصصة:
```php
$token = $downloadService->createDownloadToken(
    $user, 
    $product, 
    5,    // عدد التحميلات
    2,    // يومين صلاحية
    $orderId
);
```

### عبر API:
```bash
POST /api/store/generate-download-token
{
    "product_id": 1,
    "user_id": 123,
    "order_id": 456,
    "max_downloads": 5,      # اختياري - سيستخدم الافتراضي إذا لم يُحدد
    "expires_in_hours": 48   # اختياري - سيستخدم الافتراضي إذا لم يُحدد
}
```

## 📊 Configuration API

### جلب الإعدادات الحالية:
```bash
GET /api/store/download-config
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "default_max_downloads": 3,
        "max_downloads_limit": 10,
        "min_downloads": 1,
        "default_expiry_hours": 24,
        "max_expiry_hours": 168,
        "min_expiry_hours": 1,
        "allow_unlimited": false,
        "cleanup_expired_after_days": 30,
        "notifications": {...},
        "security": {...}
    }
}
```

## 🔧 Helper Service

### استخدام `DownloadConfigService`:
```php
use App\Services\DownloadConfigService;

// جلب القيم
$defaultMax = DownloadConfigService::getDefaultMaxDownloads();
$maxLimit = DownloadConfigService::getMaxDownloadsLimit();

// التحقق من صحة القيم
$validatedMax = DownloadConfigService::validateMaxDownloads(5);
$validatedHours = DownloadConfigService::validateExpiryHours(48);

// جلب جميع الإعدادات
$allSettings = DownloadConfigService::getAllSettings();
```

## 🚀 Benefits

1. **مرونة في التحكم**: يمكن تغيير الإعدادات دون تعديل الكود
2. **إعدادات متدرجة**: افتراضي → متغيرات البيئة → معاملات API
3. **التحقق التلقائي**: ضمان أن القيم ضمن الحدود المسموحة
4. **سهولة الإدارة**: endpoint مخصص لجلب الإعدادات
5. **قابلية التوسع**: إمكانية إضافة إعدادات جديدة بسهولة

## 📝 Notes

- جميع القيم يتم التحقق منها تلقائياً
- القيم الافتراضية محمية من القيم الخاطئة
- يمكن تخصيص الإعدادات لكل بيئة (development, production)
- الإعدادات قابلة للتغيير في runtime بدون restart للتطبيق
