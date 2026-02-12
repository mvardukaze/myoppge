<?php
global $params;
?>
<!doctype html>
<html lang="ka">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= htmlspecialchars($params['name']) ?></title>

    <meta name="theme-color" content="#16a34a" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/style.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css"/>
    <script defer src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <link rel="stylesheet" href="//cdn.web-fonts.ge/fonts/bpg-banner-supersquare-caps/css/bpg-banner-supersquare-caps.min.css">
    <style>

    </style>

    <script>
        // Tailwind config (CDN)
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ses: {
                            green: "<?= htmlspecialchars($params['primaryColor']) ?>",
                            brown: "<?= htmlspecialchars($params['buttonColor']) ?>",
                            gray: "<?= htmlspecialchars($params['textColor']) ?>",
                            bg: "<?= htmlspecialchars($params['backgroundColor']) ?>",
                            header: "<?= htmlspecialchars($params['headerColor']) ?>",
                            footer: "<?= htmlspecialchars($params['footerColor']) ?>",
                            ink: "var(--ink)",
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-ses-bg text-ses-ink antialiased" x-data="{open:false}">
<!-- Top bar -->
<div class="bg-ses-gray text-white" style="background-color: <?= htmlspecialchars($params['headerColor']) ?>;">
    <div class="mx-auto max-w-7xl px-4 py-2 flex flex-col sm:flex-row gap-2 sm:gap-4 items-start sm:items-center justify-between text-sm">
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-2"><i class="fa-solid fa-bolt"></i><?= htmlspecialchars($params['name']) ?></span>
            <span class="hidden sm:inline text-white/50">|</span>
            <span class="inline-flex items-center gap-2 text-white/90"><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($params['address']) ?></span></span>
        </div>
        <div class="flex items-center gap-4">
            <a href="tel:<?= htmlspecialchars($params['phone']) ?>" class="inline-flex items-center gap-2 hover:text-white/80">
                <i class="fa-solid fa-phone"></i> <?= htmlspecialchars($params['phone']) ?>
            </a>
            <a href="mailto:<?= htmlspecialchars($params['email']) ?>" class="inline-flex items-center gap-2 hover:text-white/80">
                <i class="fa-solid fa-envelope"></i> <?= htmlspecialchars($params['email']) ?>
            </a>
        </div>
    </div>
</div>

<!-- Header -->
<header class="sticky top-0 z-50 backdrop-blur border-b" style="background-color: <?= htmlspecialchars($params['backgroundColor']) ?>; border-color: <?= htmlspecialchars($params['primaryColor']) ?>;">
    <div class="mx-auto max-w-7xl px-4 py-3 flex items-center justify-between">
        <!-- Logo -->
        <a href="#top" class="flex items-center gap-3">
            <!-- ჩაანაცვლე logo.png შენს ფაილზე (მაგ: /assets/logo.png) -->
            <img src="logo.png" alt="<?= htmlspecialchars($params['name']) ?>" class="h-10 w-auto" />
            <div class="leading-tight hidden sm:block">
                <div class="font-semibold"><?= htmlspecialchars($params['name']) ?></div>
                <div class="text-xs text-slate-500"><?=$_SERVER['HTTP_HOST']?></div>
            </div>
        </a>

        <!-- Desktop nav -->
        <nav class="hidden lg:flex items-center gap-7 text-sm font-medium">
            <a href="#services" class="hover:text-ses-green" style="transition: color 0.2s;" onmouseover="this.style.color='<?= htmlspecialchars($params['primaryColor']) ?>'" onmouseout="this.style.color='<?= htmlspecialchars($params['textColor']) ?>'">სერვისები</a>
            <a href="#about" class="hover:text-ses-green" style="transition: color 0.2s;" onmouseover="this.style.color='<?= htmlspecialchars($params['primaryColor']) ?>'" onmouseout="this.style.color='<?= htmlspecialchars($params['textColor']) ?>'">ჩვენ შესახებ</a>
            <a href="#projects" class="hover:text-ses-green" style="transition: color 0.2s;" onmouseover="this.style.color='<?= htmlspecialchars($params['primaryColor']) ?>'" onmouseout="this.style.color='<?= htmlspecialchars($params['textColor']) ?>'">პროექტები</a>
            <a href="#faq" class="hover:text-ses-green" style="transition: color 0.2s;" onmouseover="this.style.color='<?= htmlspecialchars($params['primaryColor']) ?>'" onmouseout="this.style.color='<?= htmlspecialchars($params['textColor']) ?>'">FAQ</a>
            <a href="#contact" class="hover:text-ses-green" style="transition: color 0.2s;" onmouseover="this.style.color='<?= htmlspecialchars($params['primaryColor']) ?>'" onmouseout="this.style.color='<?= htmlspecialchars($params['textColor']) ?>'">კონტაქტი</a>

            <a href="#contact" class="inline-flex items-center gap-2 rounded-xl text-white px-4 py-2 btn-glow hover:brightness-95" style="background-color: <?= htmlspecialchars($params['primaryColor']) ?>;">
                <i class="fa-solid fa-file-signature"></i> შეთავაზების მიღება
            </a>
            <a href="" class="inline-flex items-center gap-2 rounded-xl text-white px-4 py-2 btn-glow hover:brightness-95" style="background-color: <?= htmlspecialchars($params['primaryColor']) ?>;">
                შესვლა
            </a>
        </nav>

        <!-- Mobile -->
        <button class="lg:hidden inline-flex items-center justify-center rounded-xl border px-3 py-2"
                @click="open = !open" aria-label="Open menu" style="border-color: <?= htmlspecialchars($params['primaryColor']) ?>; color: <?= htmlspecialchars($params['textColor']) ?>;">
            <i class="fa-solid" :class="open ? 'fa-xmark' : 'fa-bars'"></i>
        </button>
    </div>

    <!-- Mobile menu -->
    <div class="lg:hidden border-t" style="border-color: <?= htmlspecialchars($params['primaryColor']) ?>; background-color: <?= htmlspecialchars($params['backgroundColor']) ?>;" x-show="open" x-transition>
        <div class="mx-auto max-w-7xl px-4 py-3 flex flex-col gap-2 text-sm">
            <a @click="open=false" href="#services" class="py-2">სერვისები</a>
            <a @click="open=false" href="#about" class="py-2">ჩვენ შესახებ</a>
            <a @click="open=false" href="#projects" class="py-2">პროექტები</a>
            <a @click="open=false" href="#faq" class="py-2">FAQ</a>
            <a @click="open=false" href="#contact" class="py-2">კონტაქტი</a>
            <a @click="open=false" href="#contact" class="inline-flex items-center justify-center gap-2 rounded-xl text-white px-4 py-3 btn-glow" style="background-color: <?= htmlspecialchars($params['primaryColor']) ?>;">
                <i class="fa-solid fa-file-signature"></i> შეთავაზების მიღება
            </a>
        </div>
    </div>
</header>

<!-- Hero -->
<main id="top" class="grid-bg">
    <?php require_once("components/home.php")?>
    <?php require_once("components/services.php")?>
    <?php require_once("components/about.php")?>
   <?php  require_once "components/projects.php"?>
   <?php  require_once "components/faq.php"?>
   <?php  require_once "components/contact.php"?>
   <?php  require_once "components/footer.php"?>
</main>

<!-- Toast -->
<div id="toast" class="fixed bottom-5 left-1/2 -translate-x-1/2 hidden z-[1000]">
    <div class="rounded-2xl px-4 py-3 shadow-lg border" style="background-color: <?= htmlspecialchars($params['headerColor']) ?>; color: white; border-color: rgba(255,255,255,0.1);">
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
