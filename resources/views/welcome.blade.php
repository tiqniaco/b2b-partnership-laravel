<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>B2B Partnership - منصة الشراكات التجارية والحقائب التدريبية الرقمية</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&family=Amiri:wght@400;700&display=swap" rel="stylesheet">

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
            body {
                font-family: 'Cairo', sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            .hero-gradient {
                background: linear-gradient(135deg, rgba(102, 126, 234, 0.9) 0%, rgba(118, 75, 162, 0.9) 100%);
            }
            .card-hover {
                transition: all 0.3s ease;
            }
            .card-hover:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            }
            .floating {
                animation: float 6s ease-in-out infinite;
            }
            .floating-delay {
                animation: float 6s ease-in-out infinite;
                animation-delay: 2s;
            }
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }
            .gradient-text {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            .pulse-slow {
                animation: pulse 4s infinite;
            }
        </style>
    </head>
    <body class="min-h-screen overflow-x-hidden">
        <!-- Hero Section -->
        <section class="hero-gradient min-h-screen flex items-center justify-center relative overflow-hidden">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="floating absolute top-10 left-10 w-64 h-64 bg-white bg-opacity-10 rounded-full blur-3xl"></div>
                <div class="floating-delay absolute bottom-10 right-10 w-96 h-96 bg-white bg-opacity-5 rounded-full blur-3xl"></div>
                <div class="floating absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-white bg-opacity-5 rounded-full blur-3xl"></div>
            </div>

            <div class="container mx-auto px-6 lg:px-8 relative z-10">
                <div class="text-center">
                    <!-- Logo -->
                    <div class="mb-8 pulse-slow">
                        <img src="{{ asset('logo.png') }}" alt="B2B Partnership Logo" class="h-32 w-auto mx-auto drop-shadow-2xl">
                    </div>

                    <!-- Main Title -->
                    <h1 class="text-6xl lg:text-8xl font-bold text-white mb-6 leading-tight">
                        B2B Partnership
                    </h1>

                    <!-- Subtitle -->
                    <h2 class="text-2xl lg:text-4xl font-semibold text-blue-100 mb-8 font-amiri">
                        منصة الشراكات التجارية والحقائب التدريبية الرقمية
                    </h2>

                    <!-- Description -->
                    <p class="text-xl lg:text-2xl text-blue-50 leading-relaxed mb-12 max-w-4xl mx-auto">
                        منصة احترافية متكاملة تربط بين مقدمي الخدمات والعملاء، مع متجر رقمي متخصص في الحقائب التدريبية والمؤلفات الرقمية
                    </p>

                    <!-- Download Buttons -->
                    <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-16">
                        <a href="https://apps.apple.com/eg/app/b2b-partnership/id6743262771" target="_blank"
                           class="inline-flex items-center px-8 py-4 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-2xl shadow-2xl transition-all duration-300 transform hover:scale-105 min-w-64">
                            <i class="fab fa-apple text-2xl ml-3"></i>
                            <div class="text-right">
                                <div class="text-xs">تحميل من</div>
                                <div class="text-lg">App Store</div>
                            </div>
                        </a>

                        <a href="https://play.google.com/store/apps/details?id=tiqniq.b2b.partnership.app" target="_blank"
                           class="inline-flex items-center px-8 py-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-2xl shadow-2xl transition-all duration-300 transform hover:scale-105 min-w-64">
                            <i class="fab fa-google-play text-2xl ml-3"></i>
                            <div class="text-right">
                                <div class="text-xs">تحميل من</div>
                                <div class="text-lg">Google Play</div>
                            </div>
                        </a>
                    </div>

                    <!-- Scroll Indicator -->
                    <div class="animate-bounce">
                        <i class="fas fa-chevron-down text-white text-2xl"></i>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 bg-gray-50">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-5xl font-bold gradient-text mb-6">مميزات المنصة</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        منصة متكاملة توفر جميع الحلول التي تحتاجها لنمو أعمالك وتطوير مهاراتك
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Service Management -->
                    <div class="card-hover bg-white rounded-3xl p-8 shadow-lg border border-gray-100">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-handshake text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">إدارة الخدمات</h3>
                        <p class="text-gray-600 leading-relaxed">
                            منصة شاملة لعرض وطلب الخدمات مع نظام عروض الأسعار والتقييمات المتقدم
                        </p>
                    </div>

                    <!-- Digital Store -->
                    <div class="card-hover bg-white rounded-3xl p-8 shadow-lg border border-gray-100">
                        <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-teal-600 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-shopping-cart text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">المتجر الرقمي</h3>
                        <p class="text-gray-600 leading-relaxed">
                            متجر متخصص في الحقائب التدريبية والمؤلفات الرقمية مع نظام تحميل آمن
                        </p>
                    </div>

                    <!-- Job Market -->
                    <div class="card-hover bg-white rounded-3xl p-8 shadow-lg border border-gray-100">
                        <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-red-600 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-briefcase text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">سوق الوظائف</h3>
                        <p class="text-gray-600 leading-relaxed">
                            منصة للبحث عن الوظائف والتقديم عليها مع إدارة شاملة لطلبات التوظيف
                        </p>
                    </div>

                    <!-- Geographic System -->
                    <div class="card-hover bg-white rounded-3xl p-8 shadow-lg border border-gray-100">
                        <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-globe text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">نظام جغرافي متقدم</h3>
                        <p class="text-gray-600 leading-relaxed">
                            دعم متعدد البلدان والمحافظات مع تخصصات متنوعة لجميع المجالات
                        </p>
                    </div>

                    <!-- Training Packages -->
                    <div class="card-hover bg-white rounded-3xl p-8 shadow-lg border border-gray-100">
                        <div class="w-16 h-16 bg-gradient-to-r from-indigo-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-graduation-cap text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">الحقائب التدريبية</h3>
                        <p class="text-gray-600 leading-relaxed">
                            مجموعة شاملة من الحقائب التدريبية المتخصصة مع محتوى رقمي عالي الجودة
                        </p>
                    </div>

                    <!-- Multi-language -->
                    <div class="card-hover bg-white rounded-3xl p-8 shadow-lg border border-gray-100">
                        <div class="w-16 h-16 bg-gradient-to-r from-teal-500 to-cyan-600 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-language text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">دعم ثنائي اللغة</h3>
                        <p class="text-gray-600 leading-relaxed">
                            واجهة متكاملة باللغتين العربية والإنجليزية مع محتوى محلي ودولي
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Statistics Section -->
        <section class="py-20 bg-gradient-to-r from-gray-900 to-gray-800 text-white">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-5xl font-bold mb-6">أرقام تتحدث عن نجاحنا</h2>
                    <p class="text-xl text-gray-300">إنجازات حقيقية نفخر بها</p>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="text-5xl font-bold text-blue-400 mb-2">1000+</div>
                        <div class="text-lg text-gray-300">مقدم خدمة</div>
                    </div>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-green-400 mb-2">5000+</div>
                        <div class="text-lg text-gray-300">عميل راضي</div>
                    </div>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-yellow-400 mb-2">500+</div>
                        <div class="text-lg text-gray-300">حقيبة تدريبية</div>
                    </div>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-purple-400 mb-2">10000+</div>
                        <div class="text-lg text-gray-300">تحميل ناجح</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Download Section -->
        <section class="py-20 bg-gradient-to-r from-blue-600 to-purple-700 text-white">
            <div class="container mx-auto px-6 lg:px-8 text-center">
                <h2 class="text-5xl font-bold mb-6">ابدأ رحلتك الآن</h2>
                <p class="text-xl mb-12 max-w-3xl mx-auto">
                    حمل التطبيق واستكشف عالماً من الفرص والخدمات المتميزة
                </p>

                <div class="flex flex-col sm:flex-row gap-8 justify-center items-center">
                    <a href="https://apps.apple.com/eg/app/b2b-partnership/id6743262771" target="_blank"
                       class="inline-flex items-center px-12 py-6 bg-black hover:bg-gray-800 text-white font-bold rounded-3xl shadow-2xl transition-all duration-300 transform hover:scale-110 min-w-80">
                        <i class="fab fa-apple text-4xl ml-4"></i>
                        <div class="text-right">
                            <div class="text-sm opacity-80">متوفر على</div>
                            <div class="text-2xl">App Store</div>
                        </div>
                    </a>

                    <a href="https://play.google.com/store/apps/details?id=tiqniq.b2b.partnership.app" target="_blank"
                       class="inline-flex items-center px-12 py-6 bg-green-600 hover:bg-green-700 text-white font-bold rounded-3xl shadow-2xl transition-all duration-300 transform hover:scale-110 min-w-80">
                        <i class="fab fa-google-play text-4xl ml-4"></i>
                        <div class="text-right">
                            <div class="text-sm opacity-80">متوفر على</div>
                            <div class="text-2xl">Google Play</div>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                    <div>
                        <img src="{{ asset('logo.png') }}" alt="B2B Partnership Logo" class="h-16 w-auto mb-4">
                        <p class="text-gray-400 leading-relaxed">
                            منصة رائدة في مجال الشراكات التجارية والتدريب الرقمي
                        </p>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-4">روابط سريعة</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition-colors">من نحن</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">الخدمات</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">المتجر</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">الوظائف</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-4">تواصل معنا</h3>
                        <div class="space-y-2 text-gray-400">
                            <p><i class="fas fa-envelope ml-2"></i> info@b2bpartnership.com</p>
                            <p><i class="fas fa-phone ml-2"></i> +966 50 123 4567</p>
                            <div class="flex space-x-4 mt-4">
                                <a href="#" class="text-2xl hover:text-blue-400 transition-colors"><i class="fab fa-facebook"></i></a>
                                <a href="#" class="text-2xl hover:text-blue-400 transition-colors"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-2xl hover:text-blue-400 transition-colors"><i class="fab fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-800 pt-8 text-center">
                    <p class="text-gray-400">
                        © {{ date('Y') }} B2B Partnership — جميع الحقوق محفوظة | تطوير
                        <span class="text-blue-400 font-semibold">TIQNIA</span>
                    </p>
                </div>
            </div>
        </footer>

        <!-- Smooth Scroll Script -->
        <script>
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // Add scroll effects
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const parallax = document.querySelector('.hero-gradient');
                const speed = scrolled * 0.5;
                parallax.style.transform = `translateY(${speed}px)`;
            });
        </script>
    </body>
</html>
