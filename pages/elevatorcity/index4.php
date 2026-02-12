<?php
const INDEX = true;
require_once "system/config.php";
?>
<!doctype html>
<html lang="ka">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Smart Electric Solution | smartelectricsolution.ge</title>
    <meta name="description" content="ელექტრო ქსელის მოწყობა და მოწესრიგება • სუსტი დენები • სანათების მონტაჟი • ელექტრო ფურნიტურა • დამიწების კონტური • სასცენო განათება • სარემონტო სამუშაოები • გენერატორის მონტაჟი" />
    <meta name="theme-color" content="#16a34a" />

    <!-- Tailwind (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Icons (Font Awesome) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <!-- Alpine.js (CDN) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- AOS (scroll animations) -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css"/>
    <script defer src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <link rel="stylesheet" href="//cdn.web-fonts.ge/fonts/bpg-banner-supersquare-caps/css/bpg-banner-supersquare-caps.min.css">
    <style>

        @font-face {
            font-family: 'norm';
            src: url('/assets/BPG_110.ttf') format('opentype');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'caps';
            src: url('/assets/BPG_110_Caps.ttf') format('opentype');

        }
        @font-face {
            font-family: 'caps1';
            src: url('/assets/caps-webfont.ttf') format('opentype');
            font-weight: normal;
            font-style: normal;
        }

        :root{
            /* Brand accents */
            --ses-green:#22c55e;   /* S */
            --l1-brown:#8B5A2B;    /* L1 */
            --l2-black:#111827;    /* L2 */
            --l3-grey:#9CA3AF;     /* L3 */
            --bg:#ffffff;
            --ink:#0f172a;
        }

        /* Subtle electrical grid background */
        .grid-bg{
            background:
                    radial-gradient(transparent 0 6px, rgba(2,6,23,.03) 7px) 0 0/42px 42px,
                    linear-gradient(to right, rgba(2,6,23,.035) 1px, transparent 1px) 0 0/42px 42px,
                    linear-gradient(to bottom, rgba(2,6,23,.035) 1px, transparent 1px) 0 0/42px 42px;
        }

        /* 3-phase line accent */
        .phase-line{
            height: 4px;
            background: linear-gradient(90deg, var(--l1-brown), var(--l2-black), var(--l3-grey));
            border-radius: 9999px;
        }

        /* Button glow */
        .btn-glow{
            box-shadow: 0 10px 24px rgba(34,197,94,.18);
        }

        /* Smooth scroll */
        html { scroll-behavior: smooth; }
        body{
            font-family: norm;
        }
        .font-medium{
            font-family: caps, sans-serif;

        }
        .font-medium .py-2{
            padding-bottom: 0.40rem !important;
        }
        .font-medium a{
            padding-top: 0.55rem !important;
        }
        .font-medium.py-3{
            padding-bottom: 0.59rem;
        }

    </style>

    <script>
        // Tailwind config (CDN)
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ses: {
                            green: "var(--ses-green)",
                            l1: "var(--l1-brown)",
                            l2: "var(--l2-black)",
                            l3: "var(--l3-grey)",
                            ink: "var(--ink)",
                            bg: "var(--bg)",
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-white text-ses-ink antialiased" x-data="{open:false}">
<!-- Top bar -->
<div class="bg-slate-900 text-white">
    <div class="mx-auto max-w-7xl px-4 py-2 flex flex-col sm:flex-row gap-2 sm:gap-4 items-start sm:items-center justify-between text-sm">
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-2"><i class="fa-solid fa-bolt"></i> Smart Electric Solution</span>
            <span class="hidden sm:inline text-white/50">|</span>
            <span class="inline-flex items-center gap-2 text-white/90"><i class="fa-solid fa-location-dot"></i> თბილისი / რეგიონები</span>
        </div>
        <div class="flex items-center gap-4">
            <a href="tel:+995555000000" class="inline-flex items-center gap-2 hover:text-white/80">
                <i class="fa-solid fa-phone"></i> +995 555 00 00 00
            </a>
            <a href="mailto:info@smartelectricsolution.ge" class="inline-flex items-center gap-2 hover:text-white/80">
                <i class="fa-solid fa-envelope"></i> info@smartelectricsolution.ge
            </a>
        </div>
    </div>
</div>

<!-- Header -->
<header class="sticky top-0 z-50 bg-white/80 backdrop-blur border-b border-slate-200">
    <div class="mx-auto max-w-7xl px-4 py-3 flex items-center justify-between">
        <!-- Logo -->
        <a href="#top" class="flex items-center gap-3">
            <!-- ჩაანაცვლე logo.png შენს ფაილზე (მაგ: /assets/logo.png) -->
            <img src="logo.png" alt="Smart Electric Solution" class="h-10 w-auto" />
            <div class="leading-tight hidden sm:block">
                <div class="font-semibold">Smart Electric Solution</div>
                <div class="text-xs text-slate-500">smartelectricsolution.ge</div>
            </div>
        </a>

        <!-- Desktop nav -->
        <nav class="hidden lg:flex items-center gap-7 text-sm font-medium">
            <a href="#services" class="hover:text-ses-green">სერვისები</a>
            <a href="#about" class="hover:text-ses-green">ჩვენ შესახებ</a>
            <a href="#projects" class="hover:text-ses-green">პროექტები</a>
            <a href="#faq" class="hover:text-ses-green">FAQ</a>
            <a href="#contact" class="hover:text-ses-green">კონტაქტი</a>
            <a href="#contact" class="inline-flex items-center gap-2 rounded-xl bg-ses-green text-white px-4 py-2 btn-glow hover:brightness-95">
                <i class="fa-solid fa-file-signature"></i> შეთავაზების მიღება
            </a>
        </nav>

        <!-- Mobile -->
        <button class="lg:hidden inline-flex items-center justify-center rounded-xl border border-slate-200 px-3 py-2"
                @click="open = !open" aria-label="Open menu">
            <i class="fa-solid" :class="open ? 'fa-xmark' : 'fa-bars'"></i>
        </button>
    </div>

    <!-- Mobile menu -->
    <div class="lg:hidden border-t border-slate-200 bg-white" x-show="open" x-transition>
        <div class="mx-auto max-w-7xl px-4 py-3 flex flex-col gap-2 text-sm">
            <a @click="open=false" href="#services" class="py-2">სერვისები</a>
            <a @click="open=false" href="#about" class="py-2">ჩვენ შესახებ</a>
            <a @click="open=false" href="#projects" class="py-2">პროექტები</a>
            <a @click="open=false" href="#faq" class="py-2">FAQ</a>
            <a @click="open=false" href="#contact" class="py-2">კონტაქტი</a>
            <a @click="open=false" href="#contact" class="inline-flex items-center justify-center gap-2 rounded-xl bg-ses-green text-white px-4 py-3 btn-glow">
                <i class="fa-solid fa-file-signature"></i> შეთავაზების მიღება
            </a>
        </div>
    </div>
</header>

<!-- Hero -->
<main id="top" class="grid-bg">
    <?php require_once("components/home.php")?>

    <!-- Services -->
    <?php require_once("components/services.php")?>

    <!-- About / Why -->
    <section id="about" class="bg-slate-50 border-t border-slate-200">
        <div class="mx-auto max-w-7xl px-4 py-14 lg:py-20">
            <div class="grid lg:grid-cols-2 gap-10 items-center">
                <div data-aos="fade-up">
                    <h2 class="text-2xl sm:text-3xl font-semibold">ჩვენ შესახებ</h2>
                    <p class="mt-3 text-slate-600 leading-relaxed">
                        Smart Electric Solution უზრუნველყოფს თანამედროვე სტანდარტებზე დაფუძნებულ ელექტრო გადაწყვეტილებებს:
                        სწორი გამოთვლა, სწორი ფაზირება, დაცვა, ხარისხიანი მონტაჟი და უსაფრთხო ჩაბარება.
                    </p>

                    <div class="mt-6 grid sm:grid-cols-2 gap-4">
                        <div class="rounded-3xl bg-white border border-slate-200 p-6">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-user-shield text-ses-green text-xl"></i>
                                <div class="font-semibold">უსაფრთხოება</div>
                            </div>
                            <p class="mt-2 text-sm text-slate-600">დაცვის ავტომატიკა, წესების დაცვა, ტესტირება.</p>
                        </div>
                        <div class="rounded-3xl bg-white border border-slate-200 p-6">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-clipboard-check text-ses-green text-xl"></i>
                                <div class="font-semibold">ხარისხი</div>
                            </div>
                            <p class="mt-2 text-sm text-slate-600">სუფთა მონტაჟი, სწორი მარკირება, სქემები.</p>
                        </div>
                        <div class="rounded-3xl bg-white border border-slate-200 p-6">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-bolt-lightning text-ses-green text-xl"></i>
                                <div class="font-semibold">ენერგოეფექტურობა</div>
                            </div>
                            <p class="mt-2 text-sm text-slate-600">ოპტიმალური დატვირთვები და თანამედროვე განათება.</p>
                        </div>
                        <div class="rounded-3xl bg-white border border-slate-200 p-6">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-handshake text-ses-green text-xl"></i>
                                <div class="font-semibold">სერვისი</div>
                            </div>
                            <p class="mt-2 text-sm text-slate-600">კონსულტაცია და მხარდაჭერა შესრულების შემდეგაც.</p>
                        </div>
                    </div>
                </div>

                <div class="relative" data-aos="fade-left">
                    <div class="rounded-[2rem] overflow-hidden border border-slate-200 bg-white shadow-sm">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div class="text-sm font-semibold">როგორ ვმუშაობთ</div>
                                <div class="phase-line w-28"></div>
                            </div>

                            <ol class="mt-5 space-y-4 text-sm">
                                <li class="flex gap-3">
                                    <div class="h-9 w-9 rounded-2xl bg-emerald-50 flex items-center justify-center font-semibold text-ses-green">1</div>
                                    <div>
                                        <div class="font-medium">დათვალიერება / კონსულტაცია</div>
                                        <div class="text-slate-600 mt-1">მოთხოვნების დაზუსტება, რისკების შეფასება.</div>
                                    </div>
                                </li>
                                <li class="flex gap-3">
                                    <div class="h-9 w-9 rounded-2xl bg-emerald-50 flex items-center justify-center font-semibold text-ses-green">2</div>
                                    <div>
                                        <div class="font-medium">გათვლა / სქემა</div>
                                        <div class="text-slate-600 mt-1">დატვირთვები, დაცვა, მასალების სია.</div>
                                    </div>
                                </li>
                                <li class="flex gap-3">
                                    <div class="h-9 w-9 rounded-2xl bg-emerald-50 flex items-center justify-center font-semibold text-ses-green">3</div>
                                    <div>
                                        <div class="font-medium">მონტაჟი</div>
                                        <div class="text-slate-600 mt-1">სუფთა სამუშაო, მარკირება და წესრიგი.</div>
                                    </div>
                                </li>
                                <li class="flex gap-3">
                                    <div class="h-9 w-9 rounded-2xl bg-emerald-50 flex items-center justify-center font-semibold text-ses-green">4</div>
                                    <div>
                                        <div class="font-medium">ტესტირება / ჩაბარება</div>
                                        <div class="text-slate-600 mt-1">გადამოწმება, განმარტებები, რეკომენდაციები.</div>
                                    </div>
                                </li>
                            </ol>

                            <div class="mt-6 rounded-2xl border border-slate-200 p-4 bg-slate-50">
                                <div class="flex items-center gap-2 text-sm font-medium">
                                    <i class="fa-solid fa-circle-info text-ses-green"></i>
                                    შენიშვნა
                                </div>
                                <p class="mt-1 text-sm text-slate-600">
                                    ტექსტი/ნომრები შეცვალე რეალური ინფორმაციით (სერტიფიკატები, გარანტია, სერვისის ზონა).
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects / Gallery -->
   <?php  require_once "components/projects.php"?>

    <!-- FAQ -->
    <section id="faq" class="bg-slate-50 border-t border-slate-200">
        <div class="mx-auto max-w-7xl px-4 py-14 lg:py-20">
            <div data-aos="fade-up">
                <h2 class="text-2xl sm:text-3xl font-semibold">ხშირად დასმული კითხვები</h2>
                <p class="mt-2 text-slate-600">მოკლე პასუხები — სურვილისამებრ შეცვალე/დაამატე.</p>
            </div>

            <div class="mt-8 grid lg:grid-cols-2 gap-4" x-data="{q1:false,q2:false,q3:false,q4:false}">
                <div class="rounded-3xl border border-slate-200 bg-white p-6" data-aos="fade-up">
                    <button class="w-full flex items-center justify-between text-left" @click="q1=!q1">
                        <span class="font-semibold">აკეთებთ თუ არა 3-ფაზიან სისტემებს?</span>
                        <i class="fa-solid" :class="q1 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                    </button>
                    <div class="mt-3 text-sm text-slate-600" x-show="q1" x-transition>
                        კი — ვასრულებთ L1/L2/L3 დატვირთვების სწორ განაწილებას, დაცვას და ტესტირებას.
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6" data-aos="fade-up" data-aos-delay="50">
                    <button class="w-full flex items-center justify-between text-left" @click="q2=!q2">
                        <span class="font-semibold">დამიწების კონტური როდის არის აუცილებელი?</span>
                        <i class="fa-solid" :class="q2 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                    </button>
                    <div class="mt-3 text-sm text-slate-600" x-show="q2" x-transition>
                        უმეტეს ობიექტებზე უსაფრთხოებისთვის საჭიროა; დეტალები დამოკიდებულია ობიექტის ტიპზე და არსებული ქსელის მდგომარეობაზე.
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6" data-aos="fade-up">
                    <button class="w-full flex items-center justify-between text-left" @click="q3=!q3">
                        <span class="font-semibold">სუსტი დენები რას მოიცავს?</span>
                        <i class="fa-solid" :class="q3 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                    </button>
                    <div class="mt-3 text-sm text-slate-600" x-show="q3" x-transition>
                        CCTV, ქსელი/ინტერნეტი, სიგნალიზაცია, დომოფონი და სხვა კომუნიკაციური სისტემები.
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6" data-aos="fade-up" data-aos-delay="50">
                    <button class="w-full flex items-center justify-between text-left" @click="q4=!q4">
                        <span class="font-semibold">როგორ დავიწყოთ?</span>
                        <i class="fa-solid" :class="q4 ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                    </button>
                    <div class="mt-3 text-sm text-slate-600" x-show="q4" x-transition>
                        დაგვიკავშირდი, მოგვაწოდე მისამართი/ფოტოები და მოთხოვნა — დაგიბრუნებთ შეფასებას და ვადებს.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section id="contact" class="bg-white border-t border-slate-200">
        <div class="mx-auto max-w-7xl px-4 py-14 lg:py-20">
            <div class="grid lg:grid-cols-2 gap-10 items-start">
                <div data-aos="fade-up">
                    <h2 class="text-2xl sm:text-3xl font-semibold">კონტაქტი</h2>
                    <p class="mt-2 text-slate-600">
                        შეავსე ფორმა ან დაგვირეკე — გიპასუხებთ სწრაფად.
                    </p>

                    <div class="mt-6 space-y-3">
                        <a class="flex items-center gap-3 rounded-2xl border border-slate-200 p-4 hover:bg-slate-50" href="tel:+995555000000">
                            <div class="h-10 w-10 rounded-2xl bg-emerald-50 flex items-center justify-center">
                                <i class="fa-solid fa-phone text-ses-green"></i>
                            </div>
                            <div>
                                <div class="text-sm font-semibold">ტელეფონი</div>
                                <div class="text-sm text-slate-600">+995 555 00 00 00</div>
                            </div>
                        </a>

                        <a class="flex items-center gap-3 rounded-2xl border border-slate-200 p-4 hover:bg-slate-50" href="mailto:info@smartelectricsolution.ge">
                            <div class="h-10 w-10 rounded-2xl bg-emerald-50 flex items-center justify-center">
                                <i class="fa-solid fa-envelope text-ses-green"></i>
                            </div>
                            <div>
                                <div class="text-sm font-semibold">ელ-ფოსტა</div>
                                <div class="text-sm text-slate-600">info@smartelectricsolution.ge</div>
                            </div>
                        </a>

                        <div class="flex items-center gap-3 rounded-2xl border border-slate-200 p-4">
                            <div class="h-10 w-10 rounded-2xl bg-emerald-50 flex items-center justify-center">
                                <i class="fa-solid fa-clock text-ses-green"></i>
                            </div>
                            <div>
                                <div class="text-sm font-semibold">სამუშაო საათები</div>
                                <div class="text-sm text-slate-600">ორშ-შაბ • 10:00–19:00</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 rounded-3xl border border-slate-200 bg-slate-50 p-6">
                        <div class="text-sm font-semibold">სოციალური</div>
                        <div class="mt-3 flex gap-3">
                            <a class="h-11 w-11 rounded-2xl border border-slate-200 bg-white flex items-center justify-center hover:bg-slate-50" href="#" aria-label="Facebook">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a class="h-11 w-11 rounded-2xl border border-slate-200 bg-white flex items-center justify-center hover:bg-slate-50" href="#" aria-label="Instagram">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                            <a class="h-11 w-11 rounded-2xl border border-slate-200 bg-white flex items-center justify-center hover:bg-slate-50" href="#" aria-label="WhatsApp">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                        </div>
                        <p class="mt-3 text-xs text-slate-500">ლინკები ჩაანაცვლე რეალურით.</p>
                    </div>
                </div>

                <div class="rounded-[2rem] border border-slate-200 bg-white shadow-sm p-6 sm:p-8" data-aos="fade-left">
                    <div class="flex items-center justify-between">
                        <div class="text-lg font-semibold">მოგვწერე</div>
                        <div class="phase-line w-24"></div>
                    </div>

                    <!-- NOTE: Backend არ გვაქვს. ეს ფორმა უბრალოდ UIა. სურვილისამებრ გააკეთე submit შენი API-ზე -->
                    <form class="mt-6 space-y-4" onsubmit="event.preventDefault(); toast('მოთხოვნა მიღებულია ✅ (დემო)'); this.reset();">
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-slate-700">სახელი</label>
                                <input required type="text" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-4 focus:ring-emerald-100"
                                       placeholder="მაგ: გიორგი" />
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">ტელეფონი</label>
                                <input required type="tel" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-4 focus:ring-emerald-100"
                                       placeholder="+995 ..." />
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-700">სერვისი</label>
                            <select class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3 bg-white focus:outline-none focus:ring-4 focus:ring-emerald-100">
                                <option>ელ. ქსელის მოწყობა/მოწესრიგება</option>
                                <option>სუსტი დენები</option>
                                <option>სანათების მონტაჟი</option>
                                <option>ელექტრო ფურნიტურის მონტაჟი</option>
                                <option>დამიწების კონტური</option>
                                <option>სასცენო განათება</option>
                                <option>გენერატორის მონტაჟი</option>
                                <option>ავარიული სერვისი</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-700">მოკლე აღწერა</label>
                            <textarea rows="5" class="mt-1 w-full rounded-2xl border border-slate-200 px-4 py-3 focus:outline-none focus:ring-4 focus:ring-emerald-100"
                                      placeholder="რა ობიექტია? რა მოცულობაა? გაქვს ფოტოები?"></textarea>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
                            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-ses-green text-white px-6 py-3 font-medium btn-glow hover:brightness-95">
                                <i class="fa-solid fa-paper-plane"></i> გაგზავნა
                            </button>
                            <div class="text-xs text-slate-500">
                                გაგზავნით ეთანხმები კონტაქტზე დაბრუნებას.
                            </div>
                        </div>

                        <div class="mt-4 phase-line"></div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white">
        <div class="mx-auto max-w-7xl px-4 py-10">
            <div class="flex flex-col lg:flex-row gap-8 lg:items-center lg:justify-between">
                <div class="flex items-center gap-3">
                    <img src="logo.png" alt="Smart Electric Solution" class="h-10 w-auto bg-white rounded-xl p-1" />
                    <div>
                        <div class="font-semibold">Smart Electric Solution</div>
                        <div class="text-xs text-white/70">smartelectricsolution.ge</div>
                    </div>
                </div>

                <div class="text-sm text-white/70 max-w-2xl">
                    პროფესიონალური ელექტრო სამუშაოები: L1/L2/L3 სწორი განაწილება, უსაფრთხო მონტაჟი და ხარისხიანი შედეგი.
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-white/10 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between text-xs text-white/60">
                <div>© <span id="year"></span> Smart Electric Solution. ყველა უფლება დაცულია.</div>
                <div class="w-40">
                    <div class="phase-line"></div>
                </div>
            </div>
        </div>
    </footer>
</main>

<!-- Toast -->
<div id="toast" class="fixed bottom-5 left-1/2 -translate-x-1/2 hidden z-[1000]">
    <div class="rounded-2xl bg-slate-900 text-white px-4 py-3 shadow-lg border border-white/10">
        <div class="text-sm" id="toastText">OK</div>
    </div>
</div>

<script>
    // Init AOS
    window.addEventListener('load', () => {
        if (window.AOS) AOS.init({ once: true, duration: 650, offset: 60 });
        document.getElementById('year').textContent = new Date().getFullYear();
    });

    // Tiny toast
    function toast(msg){
        const el = document.getElementById('toast');
        const txt = document.getElementById('toastText');
        txt.textContent = msg;
        el.classList.remove('hidden');
        clearTimeout(window.__t);
        window.__t = setTimeout(()=> el.classList.add('hidden'), 2600);
    }
</script>

</body>
</html>
