<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>B2B Partnership - منصة الشراكات التجارية والحقائب التدريبية الرقمية</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            body {
                font-family: 'Cairo', sans-serif;
            }
            .fade-in {
                animation: fadeIn 1s ease-in;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .card-hover {
                transition: all 0.3s ease;
            }
            .card-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 35px rgba(10, 102, 194, 0.15);
            }
        </style>
    </head>
    <body class="bg-white text-gray-900">
        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center">
            <div class="container mx-auto px-6 py-20">
                <div class="max-w-6xl mx-auto">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <!-- Text Content -->
                        <div class="text-center lg:text-right fade-in">
                            <!-- Logo -->
                            <div class="mb-8">
                                <img src="{{ asset('logo.png') }}" alt="B2B Partnership Logo" class="h-24 w-auto mx-auto lg:mx-0">
                            </div>

                            <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                                B2B Partnership
                            </h1>

                            <h2 class="text-2xl lg:text-3xl font-semibold text-blue-600 mb-8">
                                منصة الشراكات التجارية والحقائب التدريبية الرقمية
                            </h2>

                            <p class="text-lg lg:text-xl text-gray-700 leading-relaxed mb-12 max-w-2xl mx-auto lg:mx-0">
                                منصة احترافية تمنح المؤسسات والمدربين القدرة على بيع وتسليم الحقائب التدريبية الرقمية بسهولة وأمان، مع نظام تحميل محمي وروابط صلاحية محدودة.
                            </p>

                            <!-- Download Buttons -->
                            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                                <a href="https://apps.apple.com/eg/app/b2b-partnership/id6743262771" target="_blank"
                                   class="inline-flex items-center justify-center bg-black text-white rounded-xl px-6 py-3 transition-transform hover:scale-105">
                                    <svg class="w-8 h-8 ml-3" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                                    </svg>
                                    <div class="text-right">
                                        <div class="text-xs opacity-75">تحميل من</div>
                                        <div class="text-sm font-semibold">App Store</div>
                                    </div>
                                </a>

                                <a href="https://play.google.com/store/apps/details?id=tiqniq.b2b.partnership.app" target="_blank"
                                   class="inline-flex items-center justify-center bg-green-600 text-white rounded-xl px-6 py-3 transition-transform hover:scale-105">
                                    <svg class="w-8 h-8 ml-3" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.53,12.9 20.18,13.18L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z"/>
                                    </svg>
                                    <div class="text-right">
                                        <div class="text-xs opacity-75">تحميل من</div>
                                        <div class="text-sm font-semibold">Google Play</div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- Mobile App Preview -->
                        <div class="flex justify-center lg:justify-end fade-in">
                            <div class="relative">
                                <div class="w-80 h-96 bg-gray-800 rounded-3xl p-2 shadow-2xl">
                                    <div class="w-full h-full bg-white rounded-2xl overflow-hidden">
                                        <div class="bg-blue-600 h-1/3 flex items-center justify-center">
                                            <img src="{{ asset('logo.png') }}" alt="App Logo" class="h-16 w-auto">
                                        </div>
                                        <div class="p-6 space-y-4">
                                            <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                            <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                                            <div class="h-16 bg-blue-50 rounded-lg"></div>
                                            <div class="space-y-2">
                                                <div class="h-3 bg-gray-200 rounded"></div>
                                                <div class="h-3 bg-gray-200 rounded w-5/6"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute -bottom-4 -right-4 w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18l9-5-9-5-9 5 9 5z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <div class="max-w-6xl mx-auto">
                    <div class="text-center mb-16 fade-in">
                        <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                            مميزات المنصة الشاملة
                        </h2>
                        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                            منصة متكاملة تجمع بين سوق الخدمات، الوظائف، والمتجر الإلكتروني في مكان واحد
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- نظام إدارة الخدمات -->
                        <div class="card-hover bg-white rounded-2xl p-8 border border-gray-100 shadow-lg">
                            <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">سوق الخدمات المتقدم</h3>
                            <p class="text-gray-600 leading-relaxed">
                                منصة شاملة لعرض وطلب الخدمات مع نظام عروض الأسعار والتقييمات المتقدم
                            </p>
                        </div>

                        <!-- نظام الوظائف -->
                        <div class="card-hover bg-white rounded-2xl p-8 border border-gray-100 shadow-lg">
                            <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">لوحة الوظائف الذكية</h3>
                            <p class="text-gray-600 leading-relaxed">
                                نشر وإدارة الوظائف مع نظام تقديم متقدم وإدارة شاملة للمتقدمين
                            </p>
                        </div>

                        <!-- المتجر الإلكتروني -->
                        <div class="card-hover bg-white rounded-2xl p-8 border border-gray-100 shadow-lg">
                            <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">متجر إلكتروني متكامل</h3>
                            <p class="text-gray-600 leading-relaxed">
                                منتجات رقمية مع عربة تسوق ونظام طلبات شامل وحزم منتجات ذكية
                            </p>
                        </div>

                        <!-- نظام التوثيق المتعدد -->
                        <div class="card-hover bg-white rounded-2xl p-8 border border-gray-100 shadow-lg">
                            <div class="w-16 h-16 bg-orange-100 rounded-xl flex items-center justify-center mb-6">
                                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">نظام المصادقة الآمن</h3>
                            <p class="text-gray-600 leading-relaxed">
                                مصادقة متعددة الأدوار مع Laravel Sanctum وحماية أمنية متقدمة
                            </p>
                        </div>

                        <!-- نظام التقييمات -->
                        <div class="card-hover bg-white rounded-2xl p-8 border border-gray-100 shadow-lg">
                            <div class="w-16 h-16 bg-red-100 rounded-xl flex items-center justify-center mb-6">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">نظام التقييمات الشامل</h3>
                            <p class="text-gray-600 leading-relaxed">
                                تقييم ومراجعة مقدمي الخدمات مع نظام نقاط ذكي وحساب التقييمات التلقائي
                            </p>
                        </div>

                        <!-- الإشعارات المتقدمة -->
                        <div class="card-hover bg-white rounded-2xl p-8 border border-gray-100 shadow-lg">
                            <div class="w-16 h-16 bg-indigo-100 rounded-xl flex items-center justify-center mb-6">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.828 4.828A4 4 0 015.5 4H9v1H5.5a3 3 0 00-2.121.879l-.707.707A1 1 0 113.5 5.414l.707-.707A2 2 0 015.5 4z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">إشعارات Firebase الذكية</h3>
                            <p class="text-gray-600 leading-relaxed">
                                إشعارات فورية متعددة الأنواع للهواتف مع قاعدة البيانات والبريد الإلكتروني
                            </p>
                        </div>

                        <!-- البحث المتقدم -->
                        <div class="card-hover bg-white rounded-2xl p-8 border border-gray-100 shadow-lg">
                            <div class="w-16 h-16 bg-teal-100 rounded-xl flex items-center justify-center mb-6">
                                <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">بحث وفلترة متقدمة</h3>
                            <p class="text-gray-600 leading-relaxed">
                                نظام بحث ذكي بفلاتر جغرافية وتخصصات مع ترتيب حسب التقييم والمسافة
                            </p>
                        </div>

                        <!-- إدارة الملفات الشخصية -->
                        <div class="card-hover bg-white rounded-2xl p-8 border border-gray-100 shadow-lg">
                            <div class="w-16 h-16 bg-pink-100 rounded-xl flex items-center justify-center mb-6">
                                <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">ملفات تعريفية شاملة</h3>
                            <p class="text-gray-600 leading-relaxed">
                                ملفات مفصلة للمقدمين مع معرض أعمال ووثائق رسمية وتحقق الهوية
                            </p>
                        </div>

                        <!-- النظام الجغرافي -->
                        <div class="card-hover bg-white rounded-2xl p-8 border border-gray-100 shadow-lg">
                            <div class="w-16 h-16 bg-cyan-100 rounded-xl flex items-center justify-center mb-6">
                                <svg class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">نظام جغرافي متكامل</h3>
                            <p class="text-gray-600 leading-relaxed">
                                دعم متعدد البلدان والمحافظات مع تصنيف جغرافي دقيق وخدمات محلية
                            </p>
                        </div>

                        <!-- لوحة تحكم إدارية -->
                        <div class="card-hover bg-white rounded-2xl p-8 border border-gray-100 shadow-lg">
                            <div class="w-16 h-16 bg-amber-100 rounded-xl flex items-center justify-center mb-6">
                                <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">لوحة إدارية متقدمة</h3>
                            <p class="text-gray-600 leading-relaxed">
                                إدارة شاملة مع إحصائيات مفصلة وإدارة الشكاوى وموافقات المقدمين
                            </p>
                        </div>

                        <!-- دعم متعدد اللغات -->
                        <div class="card-hover bg-white rounded-2xl p-8 border border-gray-100 shadow-lg">
                            <div class="w-16 h-16 bg-violet-100 rounded-xl flex items-center justify-center mb-6">
                                <svg class="w-8 h-8 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">دعم ثنائي اللغة</h3>
                            <p class="text-gray-600 leading-relaxed">
                                واجهة متطورة بالعربية والإنجليزية مع دعم كامل للاتجاه RTL
                            </p>
                        </div>

                        <!-- API شامل -->
                        <div class="card-hover bg-white rounded-2xl p-8 border border-gray-100 shadow-lg">
                            <div class="w-16 h-16 bg-emerald-100 rounded-xl flex items-center justify-center mb-6">
                                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">API متكامل ومتقدم</h3>
                            <p class="text-gray-600 leading-relaxed">
                                أكثر من 220 نقطة نهاية مع توثيق شامل ونظام اختبارات تلقائية
                            </p>
                        </div>

                        <!-- نظام الأمان والحماية -->
                        <div class="card-hover bg-white rounded-2xl p-8 border border-gray-100 shadow-lg">
                            <div class="w-16 h-16 bg-slate-100 rounded-xl flex items-center justify-center mb-6">
                                <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">أمان وحماية متقدمة</h3>
                            <p class="text-gray-600 leading-relaxed">
                                نظام حماية شامل مع تشفير البيانات وحماية ضد الهجمات السيبرانية
                            </p>
                        </div>

                        <!-- نظام المفضلة والحفظ -->
                        <div class="card-hover bg-white rounded-2xl p-8 border border-gray-100 shadow-lg">
                            <div class="w-16 h-16 bg-rose-100 rounded-xl flex items-center justify-center mb-6">
                                <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">نظام المفضلة الذكي</h3>
                            <p class="text-gray-600 leading-relaxed">
                                حفظ مقدمي الخدمات والوظائف المفضلة مع نظام توصيات شخصية ذكية
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-r from-blue-600 to-indigo-700">
            <div class="container mx-auto px-6 text-center">
                <div class="max-w-4xl mx-auto fade-in">
                    <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6">
                        ابدأ رحلتك الرقمية اليوم
                    </h2>
                    <p class="text-xl text-blue-100 mb-12 max-w-2xl mx-auto">
                        انضم إلى آلاف المدربين والمؤسسات التي تستخدم منصتنا لتحقيق النجاح
                    </p>

                    <div class="flex flex-col sm:flex-row gap-6 justify-center">
                        <a href="https://apps.apple.com/eg/app/b2b-partnership/id6743262771" target="_blank"
                           class="inline-flex items-center justify-center bg-black text-white rounded-xl px-8 py-4 text-lg font-semibold transition-transform hover:scale-105">
                            <svg class="w-8 h-8 ml-3" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                            </svg>
                            <div class="text-right">
                                <div class="text-sm opacity-75">تحميل من</div>
                                <div class="text-lg font-semibold">App Store</div>
                            </div>
                        </a>

                        <a href="https://play.google.com/store/apps/details?id=tiqniq.b2b.partnership.app" target="_blank"
                           class="inline-flex items-center justify-center bg-white text-green-600 rounded-xl px-8 py-4 text-lg font-semibold transition-transform hover:scale-105">
                            <svg class="w-8 h-8 ml-3" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.53,12.9 20.18,13.18L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z"/>
                            </svg>
                            <div class="text-right">
                                <div class="text-sm opacity-75">تحميل من</div>
                                <div class="text-lg font-semibold">Google Play</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-50 py-12">
            <div class="container mx-auto px-6 text-center">
                <p class="text-gray-600">
                    © {{ date('Y') }} B2B Partnership — جميع الحقوق محفوظة
                </p>
            </div>
        </footer>
    </body>
</html>
