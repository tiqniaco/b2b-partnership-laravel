# B2B Partnership Platform 🚀

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 10">
  <img src="https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.1+">
  <img src="https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Firebase-Cloud-FFCA28?style=for-the-badge&logo=firebase&logoColor=black" alt="Firebase">
</p>

## 📋 نظرة عامة على المشروع

منصة B2B Partnership هي تطبيق Laravel شامل يعمل كسوق إلكتروني يربط بين مقدمي الخدمات والعملاء. يتضمن المشروع متجر إلكتروني متكامل ونظام وظائف ونظام إدارة متقدم.

### ✨ الميزات الرئيسية

- **🔐 نظام المصادقة المتعدد الأدوار**: إدارة المستخدمين (العملاء، مقدمي الخدمات، الإدارة)
- **🛍️ متجر إلكتروني متكامل**: إدارة المنتجات، عربة التسوق، الطلبات
- **💼 سوق الخدمات**: عرض وطلب الخدمات مع نظام العروض
- **👔 لوحة الوظائف**: نشر الوظائف والتقديم عليها
- **⭐ نظام التقييمات والمراجعات**: تقييم مقدمي الخدمات
- **🌍 دعم متعدد البلدان**: نظام جغرافي شامل
- **🌐 دعم ثنائي اللغة**: العربية والإنجليزية
- **📱 إشعارات Firebase**: إشعارات فورية ومتقدمة

## 🛠️ التقنيات المستخدمة

### Backend Framework
- **Laravel 10.x** - إطار عمل PHP متقدم
- **PHP 8.1+** - أحدث إصدارات PHP
- **MySQL** - قاعدة البيانات الرئيسية

### Authentication & Security
- **Laravel Sanctum** - مصادقة API بالرموز المميزة
- **Spatie Laravel Permission** - إدارة الأدوار والصلاحيات
- **BCrypt** - تشفير كلمات المرور

### External Services
- **Firebase Cloud Messaging** - الإشعارات الفورية
- **PHPMailer** - إرسال البريد الإلكتروني
- **Vite.js** - بناء وتطوير الواجهات الأمامية

### Development Tools
- **PHPUnit** - اختبارات الوحدة
- **Laravel Factories & Seeders** - بيانات التطوير والاختبار

## 🏗️ هيكل المشروع

### الأدوار والمستخدمين
```
Users
├── Admins (المدراء)
│   ├── إدارة المنصة
│   ├── قبول/رفض مقدمي الخدمات
│   └── إدارة الشكاوى
├── Providers (مقدمو الخدمات)
│   ├── عرض الخدمات
│   ├── نشر الوظائف
│   └── إدارة الأعمال السابقة
└── Clients (العملاء)
    ├── طلب الخدمات
    ├── التقديم على الوظائف
    └── التسوق من المتجر
```

### الوحدات الأساسية

#### 1. نظام إدارة الخدمات
- **مقدمو الخدمات**: ملفات تعريفية شاملة مع الوثائق
- **خدمات مقدمة**: عرض تفصيلي للخدمات مع الميزات
- **طلبات الخدمات**: نظام طلب الخدمات من العملاء
- **عروض الأسعار**: تقديم عروض من مقدمي الخدمات
- **التقييمات**: نظام تقييم شامل

#### 2. سوق الوظائف
- **نشر الوظائف**: مع تفاصيل شاملة (الراتب، نوع العقد، الخبرة)
- **التقديم على الوظائف**: مع السيرة الذاتية وخطاب التقديم
- **إدارة الطلبات**: قبول/رفض المتقدمين
- **الوظائف المحفوظة**: حفظ الوظائف المفضلة

#### 3. المتجر الإلكتروني
- **إدارة المنتجات**: منتجات رقمية مع أوصاف متعددة اللغات
- **التصنيفات**: تنظيم المنتجات
- **عربة التسوق**: إدارة متقدمة للعربة
- **معالجة الطلبات**: نظام طلبات شامل
- **حزم المنتجات**: تجميع المنتجات في حزم

#### 4. النظام الجغرافي
- **البلدان**: دعم متعدد البلدان
- **المحافظات/الولايات**: تنظيم جغرافي تفصيلي
- **التخصصات**: تصنيف الخدمات والمهن

## 📁 هيكل قاعدة البيانات

### الجداول الرئيسية (41 جدول)

#### جداول المستخدمين
- `users` - بيانات المستخدمين الأساسية
- `providers` - ملفات مقدمي الخدمات
- `clients` - ملفات العملاء
- `admins` - حسابات الإدارة

#### جداول الخدمات
- `provider_services` - الخدمات المقدمة
- `provider_service_features` - ميزات الخدمات
- `provider_reviews` - تقييمات الخدمات
- `request_services` - طلبات الخدمات
- `request_offers` - عروض الأسعار

#### جداول الوظائف
- `jobs` - إعلانات الوظائف
- `job_applications` - طلبات التوظيف
- `saved_jobs` - الوظائف المحفوظة

#### جداول المتجر
- `store_products` - منتجات المتجر
- `store_categories` - تصنيفات المنتجات
- `store_carts` - عربة التسوق
- `store_orders` - طلبات الشراء
- `bag_contents` - حزم المنتجات

#### جداول النظام
- `countries` - البلدان
- `governments` - المحافظات/الولايات
- `specializations` - التخصصات
- `sub_specializations` - التخصصات الفرعية
- `provider_types` - أنواع مقدمي الخدمات

## 🔧 التثبيت والإعداد

### متطلبات النظام
- PHP 8.1 أو أحدث
- Composer
- MySQL 8.0 أو أحدث
- Node.js & NPM (للواجهات الأمامية)

### خطوات التثبيت

1. **استنساخ المشروع**
```bash
git clone https://github.com/tiqniaco/b2b-partnership-laravel.git
cd b2b-partnership-laravel
```

2. **تثبيت التبعيات**
```bash
composer install
npm install
```

3. **إعداد متغيرات البيئة**
```bash
cp .env.example .env
php artisan key:generate
```

4. **إعداد قاعدة البيانات**
```bash
# تحديث ملف .env بمعلومات قاعدة البيانات
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=b2b_partnership
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **تشغيل الهجرات**
```bash
php artisan migrate
php artisan db:seed
```

6. **إعداد Firebase**
```bash
# إضافة معلومات Firebase إلى .env
FIREBASE_PROJECT_ID=your_project_id
FIREBASE_PRIVATE_KEY_ID=your_private_key_id
# وضع ملف firebase-service-account.json في مجلد storage
```

7. **بناء الأصول**
```bash
npm run build
```

8. **تشغيل الخادم**
```bash
php artisan serve
```

## 🚀 API Documentation

### نقاط النهاية الرئيسية

#### Authentication
```http
POST /api/auth/register          # تسجيل مستخدم جديد
POST /api/auth/login             # تسجيل الدخول
POST /api/auth/logout            # تسجيل الخروج
POST /api/auth/reset-password    # إعادة تعيين كلمة المرور
POST /api/auth/forget-password   # نسيان كلمة المرور
```

#### Providers
```http
GET    /api/providers            # قائمة مقدمي الخدمات
POST   /api/providers            # إضافة مقدم خدمة
GET    /api/providers/{id}       # تفاصيل مقدم خدمة
PUT    /api/providers/{id}       # تحديث مقدم خدمة
DELETE /api/providers/{id}       # حذف مقدم خدمة
```

#### Services
```http
GET    /api/provider-service     # قائمة الخدمات
POST   /api/provider-service     # إضافة خدمة
GET    /api/provider-service/{id} # تفاصيل خدمة
PUT    /api/provider-service/{id} # تحديث خدمة
DELETE /api/provider-service/{id} # حذف خدمة
```

#### Jobs
```http
GET    /api/jobs                 # قائمة الوظائف
POST   /api/jobs                 # نشر وظيفة
GET    /api/jobs/{id}            # تفاصيل وظيفة
POST   /api/job-application      # التقديم على وظيفة
```

#### Store
```http
GET    /api/store/products       # منتجات المتجر
POST   /api/store/carts          # إضافة للعربة
GET    /api/store/orders         # طلبات الشراء
POST   /api/store/orders         # إنشاء طلب جديد
```

### معاملات الاستجابة المعيارية

```json
{
  "status": "success|error",
  "message": "رسالة وصفية",
  "data": {},
  "error": "تفاصيل الخطأ (في حالة الخطأ)"
}
```

## 🔒 النظام الأمني

### المصادقة والترخيص
- **Laravel Sanctum**: رموز API آمنة
- **Middleware Protection**: حماية المسارات المهمة
- **Role-based Access**: تحكم في الوصول حسب الدور
- **Input Validation**: التحقق من صحة البيانات المدخلة

### إدارة الأدوار
```php
// الأدوار المتاحة
'admin'    - مدير النظام (صلاحيات كاملة)
'provider' - مقدم خدمة (إدارة الخدمات والوظائف)
'client'   - عميل (طلب الخدمات والتسوق)
```

## 📱 نظام الإشعارات

### أنواع الإشعارات
- **إشعارات قاعدة البيانات**: للنشاطات الداخلية
- **إشعارات البريد الإلكتروني**: للتنبيهات المهمة
- **إشعارات Firebase**: للتنبيهات الفورية للهواتف

### إدارة الإشعارات
```http
POST /api/send-notification     # إرسال إشعار
GET  /api/notifications         # جلب الإشعارات
```

## 🌐 الدعم متعدد اللغات

### اللغات المدعومة
- **العربية (ar)**: اللغة الأساسية
- **الإنجليزية (en)**: اللغة الثانوية

### تطبيق التعدد اللغوي
```php
// أمثلة على الحقول متعددة اللغات
'name_ar'        // الاسم بالعربية
'name_en'        // الاسم بالإنجليزية
'description_ar' // الوصف بالعربية
'description_en' // الوصف بالإنجليزية
```

## 🧪 الاختبارات

### تشغيل الاختبارات
```bash
php artisan test                # تشغيل جميع الاختبارات
php artisan test --filter=User  # اختبارات محددة
```

### أنواع الاختبارات
- **Unit Tests**: اختبارات الوحدة
- **Feature Tests**: اختبارات الميزات
- **API Tests**: اختبارات واجهة برمجة التطبيقات

## 📊 لوحة التحكم الإدارية

### ميزات لوحة الإدارة
- **إدارة المستخدمين**: عرض وتعديل بيانات المستخدمين
- **مراجعة مقدمي الخدمات**: قبول أو رفض طلبات الانضمام
- **إدارة الشكاوى**: متابعة وحل شكاوى المستخدمين
- **إحصائيات شاملة**: تقارير الأداء والاستخدام
- **إدارة المحتوى**: البانرات والإعلانات

### نقاط النهاية الإدارية
```http
GET  /api/admin/waiting-providers    # مقدمو الخدمات في الانتظار
POST /api/admin/accept-provider      # قبول مقدم خدمة
POST /api/admin/reject-provider      # رفض مقدم خدمة
GET  /api/complaints/users           # شكاوى المستخدمين
```

## 📈 الأداء والتحسين

### استراتيجيات التحسين
- **Database Indexing**: فهرسة قواعد البيانات
- **Query Optimization**: تحسين الاستعلامات
- **Caching**: التخزين المؤقت
- **Lazy Loading**: التحميل الكسول للعلاقات

### مراقبة الأداء
```bash
php artisan route:cache    # تخزين المسارات مؤقتاً
php artisan config:cache   # تخزين التكوين مؤقتاً
php artisan view:cache     # تخزين القوالب مؤقتاً
```

## 🚀 النشر والإنتاج

### متطلبات الخادم
- **PHP 8.1+** مع الإضافات المطلوبة
- **MySQL 8.0+**
- **Nginx/Apache**
- **SSL Certificate** (مطلوب للإنتاج)

### خطوات النشر
```bash
# تحسينات الإنتاج
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

### متغيرات البيئة للإنتاج
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# قاعدة البيانات
DB_CONNECTION=mysql
DB_HOST=your_db_host
DB_DATABASE=your_db_name

# البريد الإلكتروني
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_ENCRYPTION=tls
```

## 🤝 المساهمة

### إرشادات المساهمة
1. Fork المشروع
2. إنشاء فرع للميزة الجديدة (`git checkout -b feature/amazing-feature`)
3. Commit التغييرات (`git commit -m 'Add amazing feature'`)
4. Push للفرع (`git push origin feature/amazing-feature`)
5. فتح Pull Request

### معايير الكود
- اتباع PSR-12 code style
- كتابة اختبارات للميزات الجديدة
- توثيق الكود والوظائف
- استخدام أسماء متغيرات وصفية

## 🐛 الإبلاغ عن المشاكل

### كيفية الإبلاغ
1. تحقق من المشاكل المفتوحة أولاً
2. قدم وصفاً مفصلاً للمشكلة
3. أرفق خطوات إعادة الإنتاج
4. أضف معلومات البيئة (نظام التشغيل، إصدار PHP، إلخ)

## 📞 الدعم والتواصل

### التواصل
- **البريد الإلكتروني**: info@tiqnia.co
- **الموقع**: [تقنيا](https://tiqnia.com)
- **المستودع**: [GitHub Repository](https://github.com/tiqniaco/b2b-partnership-laravel)

### الوثائق الإضافية
- [Laravel Documentation](https://laravel.com/docs)
- [User Manual](./docs/user-manual.md)

## 📄 الترخيص

هذا المشروع مرخص تحت رخصة MIT - انظر ملف [LICENSE](LICENSE) للتفاصيل.

## 📚 توثيق تفصيلي للمشروع

### 🏛️ معمارية النظام

#### هيكل المجلدات التفصيلي
```
b2b_partnership_laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/           # وحدات التحكم
│   │   │   ├── Store/            # كونترولرز المتجر
│   │   │   ├── AuthController.php # المصادقة
│   │   │   ├── ProviderController.php
│   │   │   ├── ClientController.php
│   │   │   └── AdminController.php
│   │   ├── Middleware/           # طبقات الوسطاء
│   │   └── Kernel.php           # نواة HTTP
│   ├── Models/                  # نماذج البيانات
│   │   ├── User.php            # نموذج المستخدم الأساسي
│   │   ├── Provider.php        # مقدمو الخدمات
│   │   ├── Client.php          # العملاء
│   │   ├── Admin.php           # الإدارة
│   │   ├── Job.php             # الوظائف
│   │   ├── StoreProduct.php    # منتجات المتجر
│   │   └── ... (25+ نموذج آخر)
│   ├── Services/               # خدمات الأعمال
│   └── Providers/              # مقدمو الخدمات
├── database/
│   ├── migrations/             # هجرات قاعدة البيانات (41 هجرة)
│   ├── seeders/               # بذور البيانات
│   └── factories/             # مصانع البيانات الوهمية
├── routes/
│   ├── api.php               # مسارات API (220+ نقطة نهاية)
│   ├── web.php               # مسارات الويب
│   └── channels.php          # قنوات البث
├── config/                   # ملفات التكوين
├── storage/
│   ├── firebase-service-account.json  # Firebase credentials
│   ├── app/                  # ملفات التطبيق
│   └── logs/                 # سجلات النظام
└── tests/                    # ملفات الاختبارات
```

### 🔐 تفاصيل نظام المصادقة

#### كيفية عمل المصادقة
```php
// تسجيل الدخول بالبريد الإلكتروني أو رقم الهاتف
POST /api/auth/login
{
  "login": "user@example.com|+966501234567",
  "password": "password123"
}

// الاستجابة
{
  "status": "success",
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "أحمد محمد",
      "email": "ahmed@example.com",
      "role": "provider",
      "profile_id": 15
    },
    "token": "1|abc123xyz..."
  }
}
```

#### أنواع المستخدمين وصلاحياتهم
```php
// Admin - مدير النظام
- إدارة جميع المستخدمين
- قبول/رفض مقدمي الخدمات
- إدارة الشكاوى والتقارير
- إحصائيات شاملة للمنصة
- إدارة البانرات والإعلانات

// Provider - مقدم الخدمة
- إنشاء وإدارة الخدمات
- نشر الوظائف
- إدارة الأعمال السابقة
- استقبال طلبات الخدمات
- تقديم عروض الأسعار

// Client - العميل
- طلب الخدمات
- التقديم على الوظائف
- التسوق من المتجر
- تقييم مقدمي الخدمات
- إدارة الطلبات والمفضلة
```

### 🛍️ نظام المتجر الإلكتروني المفصل

#### إدارة المنتجات
```php
// هيكل المنتج
StoreProduct {
  id: integer,
  title_ar: string,
  title_en: string,
  description_ar: text,
  description_en: text,
  price: decimal(10,2),
  discount: decimal(5,2),
  image: string,
  file: string,           // للمنتجات الرقمية
  category_id: integer,
  created_at: timestamp,
  updated_at: timestamp
}

// API المنتجات
GET /api/store/products              // قائمة المنتجات مع البحث والفلترة
POST /api/store/products             // إضافة منتج جديد
GET /api/store/products/{id}         // تفاصيل منتج
PUT /api/store/products/{id}/update  // تحديث منتج
DELETE /api/store/products/{id}      // حذف منتج
GET /api/store/top-selling-products  // المنتجات الأكثر مبيعاً
GET /api/store/recommended-products  // المنتجات المقترحة
```

#### نظام عربة التسوق
```php
// إضافة للعربة
POST /api/store/carts
{
  "product_id": 1,
  "quantity": 2
}

// عرض العربة
GET /api/store/carts

// مسح العربة
POST /api/store/cart/clear
```

#### معالجة الطلبات
```php
// إنشاء طلب
POST /api/store/orders
{
  "items": [
    {"product_id": 1, "quantity": 2},
    {"product_id": 3, "quantity": 1}
  ],
  "payment_method": "credit_card",
  "shipping_address": "عنوان التسليم"
}

// حالات الطلب
- pending: في الانتظار
- processing: قيد المعالجة
- shipped: تم الشحن
- delivered: تم التسليم
- cancelled: ملغي
```

### 💼 نظام إدارة الخدمات المفصل

#### تسجيل مقدم الخدمة
```php
// بيانات مقدم الخدمة المطلوبة
Provider {
  user_id: integer,                    // ربط بالمستخدم
  provider_types_id: integer,         // نوع مقدم الخدمة
  sub_specialization_id: integer,     // التخصص الفرعي
  governments_id: integer,            // المحافظة
  image: string,                      // صورة شخصية
  commercial_register: string,        // السجل التجاري
  tax_card: string,                   // البطاقة الضريبية
  bio: text,                          // نبذة تعريفية
  rating: integer,                    // التقييم
  verified_code: enum('0','1')       // حالة التحقق (0=غير محقق، 1=محقق)
}

// عملية الموافقة على مقدم الخدمة
POST /api/admin/accept-provider
{
  "provider_id": 15,
  "admin_notes": "تم قبول الطلب بعد مراجعة الوثائق"
}
```

#### إنشاء وإدارة الخدمات
```php
// هيكل الخدمة
ProviderService {
  id: integer,
  provider_id: integer,
  name_ar: string,
  name_en: string,
  description: text,
  price: decimal(10,2),
  image: string,
  video: string,
  address: string,
  rating: decimal(3,2),
  overview: text,
  sub_specialization_id: integer,
  governments_id: integer
}

// ميزات الخدمة
ProviderServiceFeature {
  id: integer,
  provider_service_id: integer,
  feature_ar: string,
  feature_en: string
}
```

#### نظام طلب الخدمات
```php
// طلب خدمة من العميل
POST /api/request-services
{
  "client_id": 10,
  "sub_specialization_id": 5,
  "governments_id": 3,
  "title": "تطوير موقع إلكتروني",
  "description": "أحتاج لتطوير موقع تجاري",
  "budget_min": 5000,
  "budget_max": 10000,
  "deadline": "2024-12-31",
  "requirements": "متطلبات إضافية"
}

// تقديم عرض من مقدم الخدمة
POST /api/request-offers
{
  "request_service_id": 25,
  "provider_id": 15,
  "offer_price": 7500,
  "delivery_time": "30 يوم",
  "offer_description": "وصف العرض المقدم"
}
```

### 👔 نظام الوظائف المفصل

#### نشر الوظائف
```php
// هيكل الوظيفة
Job {
  id: integer,
  provider_id: integer,              // ناشر الوظيفة
  job_title: string,
  job_description: text,
  governments_id: integer,
  image: text,
  is_urgent: boolean,
  sub_specialization_id: integer,
  start_price: decimal(10,2),        // الحد الأدنى للراتب
  end_price: decimal(10,2),          // الحد الأعلى للراتب
  salary_type: enum('monthly','weekly'),
  contract_type: enum('full_time','part_time','hourly'),
  expiration_date: date,
  status: enum('searching','closed')
}

// نشر وظيفة جديدة
POST /api/jobs
{
  "job_title": "مطور Laravel",
  "job_description": "مطلوب مطور Laravel خبرة 3 سنوات",
  "governments_id": 1,
  "sub_specialization_id": 5,
  "start_price": 8000,
  "end_price": 12000,
  "salary_type": "monthly",
  "contract_type": "full_time",
  "expiration_date": "2024-12-31",
  "requirements": "Laravel, MySQL, Git"
}
```

#### التقديم على الوظائف
```php
// طلب توظيف
POST /api/job-application
{
  "job_id": 10,
  "years_of_experience": 5,
  "cover_letter": "خطاب التقديم",
  "resume": "file", // ملف PDF للسيرة الذاتية
  "skills": "Laravel, PHP, MySQL, Vue.js",
  "available_to_start_date": "2024-02-01",
  "expected_salary": 10000,
  "why_ideal_candidate": "أسباب الترشح"
}

// إدارة طلبات التوظيف
POST /api/job-applications/{id}/update-status
{
  "status": "accepted|rejected",
  "admin_notes": "ملاحظات إدارية"
}
```

### 🌍 النظام الجغرافي والتخصصات

#### هيكل البيانات الجغرافية
```php
// البلدان
Country {
  id: integer,
  name_ar: string,
  name_en: string,
  code: string,
  flag: string
}

// المحافظات/الولايات
Government {
  id: integer,
  country_id: integer,
  name_ar: string,
  name_en: string
}

// التخصصات الرئيسية
Specialization {
  id: integer,
  name_ar: string,
  name_en: string,
  image: string
}

// التخصصات الفرعية
SubSpecialization {
  id: integer,
  specialization_id: integer,
  name_ar: string,
  name_en: string
}
```

### 📊 نظام التقييمات والمراجعات

#### تقييم مقدمي الخدمات
```php
// هيكل التقييم
ProviderReview {
  id: integer,
  provider_service_id: integer,
  client_id: integer,
  rating: integer,           // من 1 إلى 5
  review: text,
  created_at: timestamp
}

// إضافة تقييم
POST /api/provider-service-reviews
{
  "provider_service_id": 15,
  "rating": 5,
  "review": "خدمة ممتازة وسرعة في التنفيذ"
}

// حساب متوسط التقييم
SELECT AVG(rating) FROM provider_reviews 
WHERE provider_service_id = 15
```

### 🔔 نظام الإشعارات المتقدم

#### أنواع الإشعارات المختلفة
```php
// إشعارات قاعدة البيانات
Notification {
  id: integer,
  user_id: integer,
  title: string,
  message: text,
  type: string,              // job_application, service_request, order_status
  data: json,                // بيانات إضافية
  read_at: timestamp,
  created_at: timestamp
}

// إشعارات Firebase للهواتف المحمولة
Firebase Notification Types:
- new_job_posted           // وظيفة جديدة
- job_application_received // طلب توظيف جديد
- service_request_received // طلب خدمة جديد
- offer_received          // عرض سعر جديد
- order_status_updated    // تحديث حالة الطلب
- provider_approved       // موافقة على مقدم خدمة
```

#### إعداد إشعارات Firebase
```php
// ملف التكوين firebase-service-account.json
{
  "type": "service_account",
  "project_id": "b2b-partnership-47ae1",
  "private_key_id": "...",
  "private_key": "...",
  "client_email": "firebase-adminsdk-fbsvc@b2b-partnership-47ae1.iam.gserviceaccount.com",
  "client_id": "...",
  "auth_uri": "https://accounts.google.com/o/oauth2/auth",
  "token_uri": "https://oauth2.googleapis.com/token"
}

// إرسال إشعار
POST /api/send-notification
{
  "user_id": 10,
  "title": "طلب توظيف جديد",
  "message": "تم التقديم على وظيفة مطور Laravel",
  "type": "job_application",
  "data": {
    "job_id": 15,
    "applicant_id": 25
  }
}
```

### 🛡️ الأمان والحماية المتقدمة

#### طبقات الحماية
```php
// Middleware Stack
'auth:sanctum'              // مصادقة Sanctum
'role:admin'               // التحقق من الدور
'permission:manage-users'   // التحقق من الصلاحية
'throttle:60,1'            // تحديد معدل الطلبات
'verified'                 // التحقق من البريد الإلكتروني

// Input Validation Rules
$rules = [
    'email' => 'required|email|unique:users',
    'password' => 'required|min:8|confirmed',
    'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
    'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
    'file' => 'required|mimes:pdf,doc,docx|max:10240'
];
```

#### إدارة الجلسات والرموز
```php
// إعدادات Laravel Sanctum
'sanctum' => [
    'expiration' => 60 * 24,        // انتهاء الرمز بعد 24 ساعة
    'middleware' => [
        'encrypt_cookies',
        'auth:sanctum'
    ]
]

// إبطال الرموز
POST /api/auth/logout
// ينتج عنه: $user->currentAccessToken()->delete()
```

### 📈 مراقبة الأداء والإحصائيات

#### قواعد البيانات والفهرسة
```sql
-- فهارس مهمة للأداء
CREATE INDEX idx_providers_specialization ON providers(sub_specialization_id);
CREATE INDEX idx_jobs_location ON jobs(governments_id, status);
CREATE INDEX idx_services_rating ON provider_services(rating DESC);
CREATE INDEX idx_orders_status ON store_orders(status, created_at);
```

#### التخزين المؤقت (Caching)
```php
// تخزين مؤقت للبيانات المتكررة
Cache::remember('top_providers', 3600, function () {
    return Provider::with('user')
        ->where('verified_code', '1')
        ->orderBy('rating', 'desc')
        ->limit(10)
        ->get();
});

// تخزين مؤقت للاستعلامات المعقدة
Cache::remember('job_statistics', 1800, function () {
    return [
        'total_jobs' => Job::count(),
        'active_jobs' => Job::where('status', 'searching')->count(),
        'total_applications' => JobApplication::count()
    ];
});
```

### 🔄 إدارة ملفات الوسائط

#### تحميل وإدارة الصور
```php
// تحميل صورة مقدم الخدمة
if ($request->hasFile('image')) {
    $image = $request->file('image');
    $imageName = time() . '_' . $image->getClientOriginalName();
    $image->move(public_path('images/providers'), $imageName);
    $provider->image = 'images/providers/' . $imageName;
}

// تحميل ملفات المنتجات الرقمية
if ($request->hasFile('file')) {
    $file = $request->file('file');
    $fileName = time() . '_' . $file->getClientOriginalName();
    $file->move(public_path('files/products'), $fileName);
    $product->file = 'files/products/' . $fileName;
}
```

#### مجلدات الملفات
```
public/
├── images/
│   ├── providers/          # صور مقدمي الخدمات
│   ├── services/          # صور الخدمات
│   ├── products/          # صور المنتجات
│   ├── jobs/              # صور الوظائف
│   └── banners/           # صور البانرات
├── files/
│   ├── products/          # ملفات المنتجات الرقمية
│   ├── documents/         # وثائق مقدمي الخدمات
│   └── resumes/           # السير الذاتية
└── complaints/            # ملفات الشكاوى
```

### 🌐 API المتقدم وتوثيق النهايات

#### نقاط النهاية الكاملة مع أمثلة

##### Authentication APIs
```http
# تسجيل حساب جديد
POST /api/auth/register
Content-Type: application/json
{
  "name": "أحمد محمد",
  "email": "ahmed@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "phone": "0501234567",
  "country_code": "966",
  "role": "provider|client"
}

# تغيير كلمة المرور
POST /api/auth/reset-password
Authorization: Bearer {token}
{
  "current_password": "oldpassword",
  "password": "newpassword123",
  "password_confirmation": "newpassword123"
}

# نسيان كلمة المرور
POST /api/auth/forget-password
{
  "email": "user@example.com"
}

# التحقق من OTP
POST /api/verify-otp
{
  "email": "user@example.com",
  "otp": "123456"
}
```

##### Geographic APIs
```http
# جلب البلدان
GET /api/countries
Response: [
  {
    "id": 1,
    "name_ar": "المملكة العربية السعودية",
    "name_en": "Saudi Arabia",
    "code": "SA"
  }
]

# جلب المحافظات حسب البلد
GET /api/governments?country_id=1
Response: [
  {
    "id": 1,
    "name_ar": "الرياض",
    "name_en": "Riyadh",
    "country_id": 1
  }
]
```

##### Advanced Search APIs
```http
# البحث المتقدم في الخدمات
GET /api/provider-service?search=تطوير&specialization_id=1&government_id=1&min_price=1000&max_price=5000&rating=4

# البحث في الوظائف
GET /api/jobs?search=مطور&contract_type=full_time&salary_min=5000&government_id=1&urgent=true

# البحث في المنتجات
GET /api/store/products?search=تصميم&category_id=2&min_price=100&max_price=1000
```

### 📱 تكامل تطبيقات الهواتف المحمولة

#### نقاط النهاية المخصصة للجوال
```http
# تحديث معلومات الجهاز لإشعارات Firebase
POST /api/auth/update-device-token
Authorization: Bearer {token}
{
  "device_token": "firebase_device_token_here",
  "platform": "android|ios"
}

# API مبسط للجوال - الصفحة الرئيسية
GET /api/home
Response: {
  "banners": [...],
  "top_services": [...],
  "new_jobs": [...],
  "featured_providers": [...],
  "categories": [...]
}
```

### 🔧 أدوات التطوير والصيانة

#### أوامر Artisan المخصصة
```bash
# تنظيف البيانات القديمة
php artisan cleanup:old-data

# إرسال إشعارات مجدولة
php artisan notifications:send-scheduled

# تحديث إحصائيات التقييمات
php artisan ratings:update-averages

# نسخ احتياطي لقاعدة البيانات
php artisan backup:database

# إرسال تقارير دورية
php artisan reports:generate-monthly
```

#### المراقبة والسجلات
```php
// إعداد السجلات المتقدمة
'channels' => [
    'daily' => [
        'driver' => 'daily',
        'path' => storage_path('logs/laravel.log'),
        'level' => 'debug',
        'days' => 14,
    ],
    'api' => [
        'driver' => 'daily',
        'path' => storage_path('logs/api.log'),
        'level' => 'info',
    ]
]

// مراقبة الأخطاء
Log::error('Failed to process order', [
    'order_id' => $order->id,
    'user_id' => $user->id,
    'error' => $exception->getMessage()
]);
```

### 🚀 تحسينات الإنتاج المتقدمة

#### إعدادات الخادم الموصى بها
```nginx
# Nginx Configuration
server {
    listen 443 ssl http2;
    server_name yourdomain.com;
    
    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;
    
    root /var/www/b2b-partnership/public;
    index index.php;
    
    # Gzip compression
    gzip on;
    gzip_types text/plain text/css application/json application/javascript text/xml application/xml application/xml+rss text/javascript;
    
    # Security headers
    add_header X-Content-Type-Options nosniff;
    add_header X-Frame-Options DENY;
    add_header X-XSS-Protection "1; mode=block";
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

#### إعدادات قاعدة البيانات للإنتاج
```sql
-- MySQL Optimization
SET GLOBAL innodb_buffer_pool_size = 1073741824;  -- 1GB
SET GLOBAL query_cache_size = 268435456;          -- 256MB
SET GLOBAL max_connections = 200;

-- Backup Strategy
-- إنشاء نسخة احتياطية يومية
mysqldump -u username -p --single-transaction --routines --triggers b2b_partnership > backup_$(date +%Y%m%d).sql
```

### 📊 تقارير وإحصائيات المنصة

#### Dashboard الإحصائيات
```php
// إحصائيات المستخدمين
$userStats = [
    'total_users' => User::count(),
    'active_providers' => Provider::where('verified_code', '1')->count(),
    'active_clients' => Client::count(),
    'new_registrations_today' => User::whereDate('created_at', today())->count()
];

// إحصائيات الأعمال
$businessStats = [
    'total_services' => ProviderService::count(),
    'active_jobs' => Job::where('status', 'searching')->count(),
    'completed_orders' => StoreOrder::where('status', 'delivered')->count(),
    'total_revenue' => StoreOrder::where('status', 'delivered')->sum('total_amount')
];

// إحصائيات شهرية
$monthlyStats = [
    'services_created' => ProviderService::whereMonth('created_at', now()->month)->count(),
    'jobs_posted' => Job::whereMonth('created_at', now()->month)->count(),
    'orders_completed' => StoreOrder::whereMonth('created_at', now()->month)
                                  ->where('status', 'delivered')->count()
];
```

### 🎯 خطة التطوير المستقبلية

#### الميزات المقترحة
1. **نظام الدفع الإلكتروني**
   - تكامل مع بوابات الدفع السعودية (مدى، STC Pay، ماستركارد)
   - محفظة إلكترونية للمستخدمين
   - نظام العمولات والرسوم

2. **نظام المراسلة الفورية**
   - محادثات مباشرة بين العملاء ومقدمي الخدمات
   - مشاركة الملفات والصور
   - إشعارات الرسائل الفورية

3. **تطبيق الهاتف المحمول**
   - تطبيق React Native أو Flutter
   - إشعارات فورية
   - واجهة مستخدم محسّنة للجوال

4. **نظام إدارة المشاريع**
   - متابعة مراحل تنفيذ المشاريع
   - timeline للمشاريع
   - نظام الموافقات والتسليمات

5. **الذكاء الاصطناعي والتوصيات**
   - اقتراح خدمات مناسبة للعملاء
   - مطابقة المهارات مع الوظائف
   - تحليل سلوك المستخدمين

## 🗄️ توثيق قاعدة البيانات التفصيلي

### 📋 جداول قاعدة البيانات (41 جدولاً)

#### 👥 جداول إدارة المستخدمين
```sql
-- جدول المستخدمين الأساسي
users {
  id: bigint PRIMARY KEY,
  name: varchar(255),
  email: varchar(255) UNIQUE,
  email_verified_at: timestamp NULL,
  password: varchar(255),
  phone: varchar(25) NULL,
  country_code: varchar(10) NULL,
  role: enum('client','service_provider','admin') DEFAULT 'client',
  status: enum('active','inactive') DEFAULT 'active',
  otp: int(6) NULL,
  remember_token: varchar(100) NULL,
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول مقدمي الخدمات
providers {
  id: bigint PRIMARY KEY,
  user_id: bigint FOREIGN KEY → users(id),
  provider_types_id: bigint FOREIGN KEY → provider_types(id),
  sub_specialization_id: bigint FOREIGN KEY → sub_specializations(id),
  governments_id: bigint FOREIGN KEY → governments(id),
  image: text,
  commercial_register: text,
  tax_card: text,
  bio: text,
  rating: int DEFAULT 0,
  verified_code: enum('0','1') DEFAULT '0',
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول العملاء
clients {
  id: bigint PRIMARY KEY,
  user_id: bigint FOREIGN KEY → users(id),
  governments_id: bigint FOREIGN KEY → governments(id),
  image: text,
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول الإدارة
admins {
  id: bigint PRIMARY KEY,
  user_id: bigint FOREIGN KEY → users(id),
  governments_id: bigint FOREIGN KEY → governments(id),
  created_at: timestamp,
  updated_at: timestamp
}
```

#### 🌍 جداول النظام الجغرافي
```sql
-- جدول البلدان
countries {
  id: bigint PRIMARY KEY,
  name_ar: varchar(255),
  name_en: varchar(255),
  code: varchar(10),
  flag: text,
  phone_length: int,
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول المحافظات/الولايات
governments {
  id: bigint PRIMARY KEY,
  country_id: bigint FOREIGN KEY → countries(id),
  name_ar: varchar(255),
  name_en: varchar(255),
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول التخصصات الرئيسية
specializations {
  id: bigint PRIMARY KEY,
  name_ar: varchar(255),
  name_en: varchar(255),
  image: text,
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول التخصصات الفرعية
sub_specializations {
  id: bigint PRIMARY KEY,
  parent_id: bigint FOREIGN KEY → specializations(id),
  name_ar: varchar(255),
  name_en: varchar(255),
  image: text,
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول أنواع مقدمي الخدمات
provider_types {
  id: bigint PRIMARY KEY,
  name_ar: varchar(255),
  name_en: varchar(255),
  created_at: timestamp,
  updated_at: timestamp
}
```

#### 💼 جداول الخدمات والأعمال
```sql
-- جدول خدمات مقدمي الخدمات
provider_services {
  id: bigint PRIMARY KEY,
  provider_id: bigint FOREIGN KEY → providers(id) ON DELETE CASCADE,
  governments_id: bigint FOREIGN KEY → governments(id),
  sub_specialization_id: bigint FOREIGN KEY → sub_specializations(id),
  name_ar: varchar(255),
  name_en: varchar(255),
  address: text NULL,
  description: text,
  image: text,
  price: double NULL,
  rating: int DEFAULT 0,
  overview: text,
  video: varchar(255) NULL,
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول ميزات الخدمات
provider_service_features {
  id: bigint PRIMARY KEY,
  provider_service_id: bigint FOREIGN KEY → provider_services(id) ON DELETE CASCADE,
  feature_ar: varchar(255),
  feature_en: varchar(255),
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول تقييمات مقدمي الخدمات
provider_reviews {
  id: bigint PRIMARY KEY,
  provider_id: bigint FOREIGN KEY → providers(id) ON DELETE CASCADE,
  user_id: bigint FOREIGN KEY → users(id) ON DELETE CASCADE,
  review: text,
  rating: int,
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول طلبات الخدمات
request_services {
  id: bigint PRIMARY KEY,
  client_id: bigint FOREIGN KEY → clients(id) ON DELETE CASCADE,
  governments_id: bigint FOREIGN KEY → governments(id),
  sub_specialization_id: bigint FOREIGN KEY → sub_specializations(id),
  title_ar: varchar(255),
  title_en: varchar(255),
  address: text,
  description: text,
  image: text NULL,
  status: enum('pending','confirmed','canceled') DEFAULT 'pending',
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول عروض الأسعار
request_offers {
  id: bigint PRIMARY KEY,
  request_service_id: bigint FOREIGN KEY → request_services(id) ON DELETE CASCADE,
  provider_id: bigint FOREIGN KEY → providers(id) ON DELETE CASCADE,
  offer_description: text,
  price: decimal(10,2),
  status: enum('pending','accepted','rejected') DEFAULT 'pending',
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول مقدمي الخدمات المفضلين
favorite_providers {
  id: bigint PRIMARY KEY,
  user_id: bigint FOREIGN KEY → users(id) ON DELETE CASCADE,
  provider_id: bigint FOREIGN KEY → providers(id) ON DELETE CASCADE,
  created_at: timestamp,
  updated_at: timestamp
}
```

#### 👔 جداول الوظائف
```sql
-- جدول الوظائف (النسخة المحدثة)
jobs {
  id: bigint PRIMARY KEY,
  title: varchar(255),
  description: text,
  skills: text,
  experience: text,
  contract_type: varchar(255),
  expiry_date: date,
  status: enum('hired','searching') DEFAULT 'searching',
  gender: enum('male','female','any') DEFAULT 'any',
  salary: int NULL,
  sub_specializations_id: bigint FOREIGN KEY → sub_specializations(id) ON DELETE CASCADE,
  government_id: bigint FOREIGN KEY → governments(id) ON DELETE CASCADE,
  employer_id: bigint FOREIGN KEY → providers(id) ON DELETE CASCADE,
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول طلبات التوظيف
job_applications {
  id: bigint PRIMARY KEY,
  job_id: bigint FOREIGN KEY → jobs(id) ON DELETE CASCADE,
  user_id: bigint FOREIGN KEY → users(id) ON DELETE CASCADE,
  years_of_experience: int,
  cover_letter: text NULL,
  resume: varchar(255) NULL,
  skills: text NULL,
  available_to_start_date: date NULL,
  expected_salary: int NULL,
  why_ideal_candidate: text NULL,
  status: enum('pending','accepted','rejected') DEFAULT 'pending',
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول الوظائف المحفوظة
saved_jobs {
  id: bigint PRIMARY KEY,
  user_id: bigint FOREIGN KEY → users(id) ON DELETE CASCADE,
  job_id: bigint FOREIGN KEY → jobs(id) ON DELETE CASCADE,
  created_at: timestamp,
  updated_at: timestamp
}
```

#### 🛒 جداول المتجر الإلكتروني
```sql
-- جدول تصنيفات المنتجات
store_categories {
  id: bigint PRIMARY KEY,
  name_ar: varchar(255),
  name_en: varchar(255),
  image: varchar(255) NULL,
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول منتجات المتجر
store_products {
  id: bigint PRIMARY KEY,
  title_ar: varchar(255),
  title_en: varchar(255),
  description_ar: text,
  description_en: text,
  file: text,                    -- للمنتجات الرقمية
  price: decimal(10,2),
  discount: decimal(5,2) DEFAULT 0,
  image: text NULL,
  category_id: bigint FOREIGN KEY → store_categories(id) ON DELETE CASCADE,
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول عربة التسوق
store_carts {
  id: bigint PRIMARY KEY,
  user_id: bigint FOREIGN KEY → users(id) ON DELETE CASCADE,
  product_id: bigint FOREIGN KEY → store_products(id) ON DELETE CASCADE,
  quantity: int DEFAULT 1,
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول طلبات الشراء
store_orders {
  id: bigint PRIMARY KEY,
  user_id: bigint FOREIGN KEY → users(id) ON DELETE CASCADE,
  total_amount: decimal(10,2),
  status: enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  payment_method: varchar(100),
  shipping_address: text,
  notes: text NULL,
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول تفاصيل الطلبات
order_items {
  id: bigint PRIMARY KEY,
  order_id: bigint FOREIGN KEY → store_orders(id) ON DELETE CASCADE,
  product_id: bigint FOREIGN KEY → store_products(id),
  quantity: int,
  price: decimal(10,2),
  total: decimal(10,2),
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول حزم المنتجات
bag_contents {
  id: bigint PRIMARY KEY,
  name_en: varchar(255),
  name_ar: varchar(255),
  image: varchar(255),
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول ربط المنتجات بالحزم
bag_content_store_product {
  id: bigint PRIMARY KEY,
  bag_content_id: bigint FOREIGN KEY → bag_contents(id) ON DELETE CASCADE,
  store_product_id: bigint FOREIGN KEY → store_products(id) ON DELETE CASCADE,
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول أوصاف المنتجات المفصلة
product_description_titles {
  id: bigint PRIMARY KEY,
  title_en: varchar(255),
  title_ar: varchar(255),
  product_id: bigint FOREIGN KEY → store_products(id) ON DELETE CASCADE,
  created_at: timestamp,
  updated_at: timestamp
}

product_description_contents {
  id: bigint PRIMARY KEY,
  content_en: text,
  content_ar: text,
  title_id: bigint FOREIGN KEY → product_description_titles(id) ON DELETE CASCADE,
  created_at: timestamp,
  updated_at: timestamp
}
```

#### 📞 جداول الدعم والتواصل
```sql
-- جدول الشكاوى
complaints {
  id: bigint PRIMARY KEY,
  sender_id: bigint FOREIGN KEY → users(id),
  receiver_id: bigint FOREIGN KEY → admins(id),
  user_id: bigint FOREIGN KEY → users(id),
  content: text,
  content_type: enum('text','image','voice') DEFAULT 'text',
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول معلومات الاتصال للمتجر
shop_contact_us {
  id: bigint PRIMARY KEY,
  whatsapp: varchar(255),
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول الإشعارات
notifications {
  id: bigint PRIMARY KEY,
  user_id: bigint FOREIGN KEY → users(id),
  title: varchar(255),
  message: text,
  type: varchar(100),
  data: json NULL,
  read_at: timestamp NULL,
  created_at: timestamp,
  updated_at: timestamp
}

-- جدول البانرات الإعلانية
banners {
  id: bigint PRIMARY KEY,
  image: text,
  status: enum('active','inactive') DEFAULT 'active',
  created_at: timestamp,
  updated_at: timestamp
}
```

#### 🔐 جداول الأمان والصلاحيات
```sql
-- جدول الأدوار (Spatie Permission)
roles {
  id: bigint PRIMARY KEY,
  name: varchar(255),
  guard_name: varchar(255),
  created_at: timestamp,
  updated_at: timestamp,
  UNIQUE KEY roles_name_guard_name_unique (name, guard_name)
}

-- جدول الصلاحيات
permissions {
  id: bigint PRIMARY KEY,
  name: varchar(255),
  guard_name: varchar(255),
  created_at: timestamp,
  updated_at: timestamp,
  UNIQUE KEY permissions_name_guard_name_unique (name, guard_name)
}

-- جدول ربط الأدوار بالصلاحيات
role_has_permissions {
  permission_id: bigint FOREIGN KEY → permissions(id) ON DELETE CASCADE,
  role_id: bigint FOREIGN KEY → roles(id) ON DELETE CASCADE,
  PRIMARY KEY (permission_id, role_id)
}

-- جدول ربط المستخدمين بالأدوار
model_has_roles {
  role_id: bigint FOREIGN KEY → roles(id) ON DELETE CASCADE,
  model_type: varchar(255),
  model_id: bigint,
  PRIMARY KEY (role_id, model_id, model_type)
}

-- جدول رموز الوصول الشخصية (Laravel Sanctum)
personal_access_tokens {
  id: bigint PRIMARY KEY,
  tokenable_type: varchar(255),
  tokenable_id: bigint,
  name: varchar(255),
  token: varchar(64) UNIQUE,
  abilities: text NULL,
  last_used_at: timestamp NULL,
  expires_at: timestamp NULL,
  created_at: timestamp,
  updated_at: timestamp,
  INDEX personal_access_tokens_tokenable_type_tokenable_id_index (tokenable_type, tokenable_id)
}
```

### 📊 Database Views (عروض قاعدة البيانات)

المشروع يستخدم عروض قاعدة البيانات المعقدة لتبسيط الاستعلامات وتحسين الأداء:

#### 🔍 عروض التفاصيل الرئيسية
```sql
-- عرض تفاصيل مقدمي الخدمات
CREATE VIEW provider_details AS
SELECT 
    users.id AS user_id,
    users.name, users.email, users.phone,
    providers.id AS provider_id,
    providers.bio, providers.rating,
    provider_types.name_ar AS provider_type_name_ar,
    provider_types.name_en AS provider_type_name_en,
    specializations.name_ar AS specialization_name_ar,
    specializations.name_en AS specialization_name_en,
    sub_specializations.name_ar AS sub_specialization_name_ar,
    sub_specializations.name_en AS sub_specialization_name_en,
    countries.name_ar AS country_name_ar,
    countries.name_en AS country_name_en,
    governments.name_ar AS government_name_ar,
    governments.name_en AS government_name_en,
    providers.verified_code
FROM providers
JOIN users ON providers.user_id = users.id
JOIN provider_types ON providers.provider_types_id = provider_types.id
JOIN sub_specializations ON providers.sub_specialization_id = sub_specializations.id
JOIN specializations ON sub_specializations.parent_id = specializations.id
JOIN governments ON providers.governments_id = governments.id
JOIN countries ON governments.country_id = countries.id;

-- عرض تفاصيل الخدمات
CREATE VIEW provider_service_details AS
SELECT 
    provider_services.*,
    countries.name_ar AS country_name_ar,
    countries.name_en AS country_name_en,
    governments.name_ar AS government_name_ar,
    governments.name_en AS government_name_en,
    specializations.name_ar AS specialization_name_ar,
    specializations.name_en AS specialization_name_en,
    sub_specializations.name_ar AS sub_specialization_name_ar,
    sub_specializations.name_en AS sub_specialization_name_en
FROM provider_services
JOIN sub_specializations ON provider_services.sub_specialization_id = sub_specializations.id
JOIN specializations ON sub_specializations.parent_id = specializations.id
JOIN governments ON provider_services.governments_id = governments.id
JOIN countries ON governments.country_id = countries.id;

-- عرض تفاصيل الوظائف
CREATE VIEW job_details_view AS
SELECT 
    jobs.*,
    users.name AS employer_name,
    users.email AS employer_email,
    providers.bio AS employer_bio,
    providers.rating AS employer_rating,
    specializations.name_ar AS specialization_name_ar,
    specializations.name_en AS specialization_name_en,
    sub_specializations.name_ar AS sub_specialization_name_ar,
    sub_specializations.name_en AS sub_specialization_name_en,
    governments.name_ar AS government_name_ar,
    governments.name_en AS government_name_en,
    countries.name_ar AS country_name_ar,
    countries.name_en AS country_name_en
FROM jobs
JOIN providers ON jobs.employer_id = providers.id
JOIN users ON providers.user_id = users.id
JOIN sub_specializations ON jobs.sub_specializations_id = sub_specializations.id
JOIN specializations ON sub_specializations.parent_id = specializations.id
JOIN governments ON jobs.government_id = governments.id
JOIN countries ON governments.country_id = countries.id;

-- عرض تفاصيل طلبات الخدمات
CREATE VIEW request_service_details_view AS
SELECT 
    request_services.*,
    users.name AS client_name,
    users.email AS client_email,
    users.phone AS client_phone,
    specializations.name_ar AS specialization_name_ar,
    specializations.name_en AS specialization_name_en,
    sub_specializations.name_ar AS sub_specialization_name_ar,
    sub_specializations.name_en AS sub_specialization_name_en,
    governments.name_ar AS government_name_ar,
    governments.name_en AS government_name_en,
    countries.name_ar AS country_name_ar,
    countries.name_en AS country_name_en
FROM request_services
JOIN clients ON request_services.client_id = clients.id
JOIN users ON clients.user_id = users.id
JOIN sub_specializations ON request_services.sub_specialization_id = sub_specializations.id
JOIN specializations ON sub_specializations.parent_id = specializations.id
JOIN governments ON request_services.governments_id = governments.id
JOIN countries ON governments.country_id = countries.id;
```

### 🔗 العلاقات بين الجداول (Relationships)

#### العلاقات الرئيسية في النظام
```php
// User Model Relationships
User hasOne Provider
User hasOne Client  
User hasOne Admin
User hasMany JobApplications
User hasMany Notifications
User hasMany StoreOrders

// Provider Model Relationships
Provider belongsTo User
Provider belongsTo ProviderType
Provider belongsTo SubSpecialization
Provider belongsTo Government
Provider hasMany ProviderServices
Provider hasMany Jobs
Provider hasMany ProviderReviews
Provider hasMany RequestOffers

// Client Model Relationships
Client belongsTo User
Client belongsTo Government
Client hasMany RequestServices

// Job Model Relationships
Job belongsTo Provider (as employer)
Job belongsTo Government
Job belongsTo SubSpecialization
Job hasMany JobApplications
Job belongsToMany Users (through SavedJobs)

// ProviderService Model Relationships
ProviderService belongsTo Provider
ProviderService belongsTo Government
ProviderService belongsTo SubSpecialization
ProviderService hasMany ProviderServiceFeatures
ProviderService hasMany ProviderReviews

// StoreProduct Model Relationships
StoreProduct belongsTo StoreCategory
StoreProduct hasMany StoreCartItems
StoreProduct hasMany OrderItems
StoreProduct belongsToMany BagContents

// Geographic Relationships
Country hasMany Governments
Government belongsTo Country
Government hasMany Providers
Government hasMany Clients
Government hasMany Jobs

Specialization hasMany SubSpecializations
SubSpecialization belongsTo Specialization
SubSpecialization hasMany Providers
SubSpecialization hasMany Jobs
SubSpecialization hasMany ProviderServices
```

### 📈 فهارس قاعدة البيانات للأداء

```sql
-- فهارس أساسية للبحث والفلترة
CREATE INDEX idx_providers_verified ON providers(verified_code);
CREATE INDEX idx_providers_rating ON providers(rating DESC);
CREATE INDEX idx_providers_specialization ON providers(sub_specialization_id, governments_id);

CREATE INDEX idx_jobs_status ON jobs(status, expiry_date);
CREATE INDEX idx_jobs_location ON jobs(government_id, contract_type);
CREATE INDEX idx_jobs_specialization ON jobs(sub_specializations_id, status);

CREATE INDEX idx_services_rating ON provider_services(rating DESC, sub_specialization_id);
CREATE INDEX idx_services_location ON provider_services(governments_id, rating);

CREATE INDEX idx_products_category ON store_products(category_id, price);
CREATE INDEX idx_products_price ON store_products(price ASC);

CREATE INDEX idx_orders_user ON store_orders(user_id, status);
CREATE INDEX idx_orders_status ON store_orders(status, created_at);

CREATE INDEX idx_notifications_user ON notifications(user_id, read_at);
CREATE INDEX idx_reviews_provider ON provider_reviews(provider_id, rating);

-- فهارس للبحث النصي
CREATE FULLTEXT INDEX idx_jobs_search ON jobs(title, description, skills);
CREATE FULLTEXT INDEX idx_services_search ON provider_services(name_ar, name_en, description);
CREATE FULLTEXT INDEX idx_products_search ON store_products(title_ar, title_en, description_ar, description_en);
```

---

<p align="center">
  صُنع بـ ❤️ من قبل <a href="https://tiqnia.com">فريق تقنيه</a>
</p>

