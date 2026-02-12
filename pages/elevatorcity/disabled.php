<?php
global $params;
?>
<!DOCTYPE html>
<html lang="ka">
<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($params['name']) ?> – Under Construction</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex, nofollow">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sesGreen: '<?= htmlspecialchars($params['primaryColor']) ?>',
                        sesBrown: '<?= htmlspecialchars($params['buttonColor']) ?>',
                        sesGray: '<?= htmlspecialchars($params['textColor']) ?>',
                        sesBg: '<?= htmlspecialchars($params['backgroundColor']) ?>',
                        sesHeader: '<?= htmlspecialchars($params['headerColor']) ?>',
                        sesFooter: '<?= htmlspecialchars($params['footerColor']) ?>'
                    }
                }
            }
        }
    </script>
</head>

<body class="min-h-screen bg-sesBg text-sesGray flex items-center justify-center">
<div class="w-full max-w-2xl px-4">
    <div class="rounded-3xl p-8 md:p-10 shadow-xl" style="background-color: <?= htmlspecialchars($params['backgroundColor']) ?>; border: 1px solid <?= htmlspecialchars($params['primaryColor']) ?>;">

        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img
                    src="<?= htmlspecialchars($params['logo']) ?>"
                    alt="<?= htmlspecialchars($params['name']) ?> Logo"
                    class="h-20 md:h-24"
            />
        </div>

        <!-- Title -->
        <h1 class="text-2xl md:text-3xl font-semibold text-center mb-3" style="color: <?= htmlspecialchars($params['headerColor']) ?>;">
            ვებგვერდი მზადების პროცესშია
        </h1>

        <p class="text-center text-sm md:text-base mb-6" style="color: <?= htmlspecialchars($params['textColor']) ?>;">
            <?= htmlspecialchars($params['name']) ?> — მალე დაგიბრუნდებით ახალი საიტით.
        </p>

        <!-- Progress bar -->
        <div class="w-full h-2 rounded-full overflow-hidden mb-8" style="background-color: <?= htmlspecialchars($params['textColor']) ?>; opacity: 0.2;">
            <div class="h-full w-2/3 animate-pulse" style="background: linear-gradient(90deg, <?= htmlspecialchars($params['primaryColor']) ?>, <?= htmlspecialchars($params['buttonColor']) ?>, <?= htmlspecialchars($params['textColor']) ?>);"></div>
        </div>

        <!-- Contact -->
        <div class="space-y-4 text-center">
            <div>
                <p class="text-sm mb-1" style="color: <?= htmlspecialchars($params['textColor']) ?>; opacity: 0.7;">დაკავშირება</p>
                <a href="tel:<?= htmlspecialchars($params['phone']) ?>"
                   class="inline-flex items-center justify-center gap-2 text-lg font-medium text-sesGreen hover:text-sesBrown transition">
                    Tel / WhatsApp: <?= htmlspecialchars($params['phone']) ?>
                </a>
            </div>

            <!-- Facebook -->
            <div>
                <p class="text-sm mb-1" style="color: <?= htmlspecialchars($params['textColor']) ?>; opacity: 0.7;">Facebook</p>
                <a
                        href="<?= htmlspecialchars($params['fb']) ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-sesGreen text-sesGray hover:bg-sesGreen hover:text-white transition"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4 fill-current">
                        <path d="M22 12.06C22 6.505 17.523 2 12 2S2 6.505 2 12.06C2 17.084 5.657 21.245 10.438 22v-6.994H7.898v-2.946h2.54V9.845c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.196 2.238.196v2.48h-1.261c-1.243 0-1.63.776-1.63 1.572v1.884h2.773l-.443 2.946h-2.33V22C18.343 21.245 22 17.084 22 12.06z"/>
                    </svg>
                    Facebook გვერდი.
                </a>
            </div>
        </div>

        <!-- Footer -->
        <p class="mt-8 text-center text-xs" style="color: <?= htmlspecialchars($params['footerColor']) ?>; opacity: 0.7;">
            © <?=date('y')?> <?= htmlspecialchars($params['name']) ?>. ყველა უფლება დაცულია.
        </p>
    </div>
</div>


</body>
</html>
