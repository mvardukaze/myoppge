<?php
global $params;
?>
<footer class="text-white" style="background-color: <?= htmlspecialchars($params['headerColor']) ?>;">
    <div class="mx-auto max-w-7xl px-4 py-10">
        <div class="flex flex-col lg:flex-row gap-8 lg:items-center lg:justify-between">
            <div class="flex items-center gap-3">
                <img src="logo.png" alt="<?= htmlspecialchars($params['name']) ?>" class="h-10 w-auto bg-white rounded-xl p-1" />
                <div>
                    <div class="font-semibold"><?= htmlspecialchars($params['name']) ?></div>
                    <div class="text-xs text-white/70"><?=$_SERVER['HTTP_HOST']?></div>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-white/10 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between text-xs text-white/60">
            <div>© <span id="year"></span> <?= htmlspecialchars($params['name']) ?>. ყველა უფლება დაცულია.</div>
            <div class="w-40">
                <div class="phase-line"></div>
            </div>
        </div>
    </div>
</footer>
