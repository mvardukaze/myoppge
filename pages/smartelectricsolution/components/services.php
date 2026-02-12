<?php

defined('INDEX') or error('Access denied',403);
global $db ,$services;
?>

<style>
    /* iOS-friendly scroll lock */
    .no-scroll { overflow: hidden; touch-action: none; }
</style>

<section id="services" class="" style="background-color: <?= htmlspecialchars($params['backgroundColor']) ?>; border-top: 1px solid <?= htmlspecialchars($params['primaryColor']) ?>;">
    <div class="mx-auto max-w-7xl px-4 py-14 lg:py-20">

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5">
            <div data-aos="fade-up">
                <h2 class="text-2xl sm:text-3xl font-semibold">სერვისები</h2>
            </div>

            <a href="#contact"
               class="inline-flex items-center justify-center gap-2 rounded-2xl text-white px-6 py-3 font-medium hover:brightness-110" style="background-color: <?= htmlspecialchars($params['primaryColor']) ?>;">
                <i class="fa-solid fa-phone"></i> დაგვიკავშირდით
            </a>
        </div>

        <div x-data="servicesUI()" class="mt-10">

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">

                <?php foreach ($services as $i => $s):
                    $delay = ($i % 3) * 50; // 0 / 50 / 100
                    $payload = htmlspecialchars(json_encode([
                            'icon'  => $s['icon']  ?? 'fa-bolt',
                            'title' => $s['title'] ?? '',
                            'short' => $s['short'] ?? '',
                            'detail'=> $s['detail'] ?? '',
                    ], JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8');
                    ?>

                    <button
                            type="button"
                            class="text-left rounded-3xl p-6 hover:shadow-sm transition w-full" style="border: 1px solid <?= htmlspecialchars($params['primaryColor']) ?>; background-color: <?= htmlspecialchars($params['backgroundColor']) ?>;"
                            data-aos="fade-up"
                            data-aos-delay="<?= (int)$delay ?>"
                            data-service='<?= $payload ?>'
                            @click="openFromEl($el)"
                    >
                        <div class="flex items-center justify-between">
                            <div class="h-12 w-12 rounded-2xl flex items-center justify-center" style="background-color: <?= htmlspecialchars($params['primaryColor']) ?>20;">

                                <img src="<?=$s['icon'] ?>" class="rounded-2xl"/>
                            </div>
                            <div class="phase-line w-16"></div>
                        </div>

                        <h3 class="mt-4 font-semibold text-lg" style="color: <?= htmlspecialchars($params['headerColor']) ?>;"><?= htmlspecialchars($s['title'] ?? '') ?></h3>
                        <p class="mt-2 text-sm" style="color: <?= htmlspecialchars($params['textColor']) ?>;"><?= htmlspecialchars($s['short'] ?? '') ?></p>

                        <div class="mt-4 text-sm font-semibold inline-flex items-center gap-2" style="color: <?= htmlspecialchars($params['primaryColor']) ?>;">
                            დეტალურად <i class="fa-solid fa-arrow-right text-xs"></i>
                        </div>
                    </button>

                <?php endforeach; ?>

            </div>

            <!-- MODAL -->
            <div
                    x-show="open"
                    x-cloak
                    @keydown.escape.window="close()"
                    class="fixed inset-0 z-[999] flex items-center justify-center p-4 overscroll-contain"
                    aria-modal="true"
                    role="dialog"
            >
                <div class="absolute inset-0" style="background-color: <?= htmlspecialchars($params['headerColor']) ?>; opacity: 0.6;" @click="close()"></div>

                <div
                        x-transition
                        @click.stop
                        class="relative w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden max-h-[85vh] flex flex-col" style="background-color: <?= htmlspecialchars($params['backgroundColor']) ?>;"
                >
                    <button
                            type="button"
                            @click="close()"
                            class="absolute right-4 top-4 z-20 inline-flex h-10 w-10 items-center justify-center rounded-full shadow" style="background-color: <?= htmlspecialchars($params['backgroundColor']) ?>; color: <?= htmlspecialchars($params['textColor']) ?>;"
                            aria-label="Close"
                    >
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                    <div class="p-6 sm:p-8 overflow-y-auto">
                        <div class="flex items-start gap-4">
                            <div class="h-12 w-12 rounded-2xl bg-emerald-50 flex items-center justify-center shrink-0">
                                <img class="fa-solid text-ses-green text-xl" :src="service?.icon"/>
                            </div>

                            <div class="min-w-0">
                                <h3 class="text-2xl font-semibold tracking-tight text-slate-900" x-text="service?.title"></h3>
                                <p class="mt-1 text-sm text-slate-600" x-text="service?.short"></p>
                            </div>
                        </div>

                        <div class="mt-5 rounded-2xl bg-slate-50 p-5 text-slate-700 leading-relaxed break-words whitespace-pre-line">
                            <p x-text="service?.detail"></p>
                        </div>

                        <div class="mt-6 flex flex-col sm:flex-row gap-3">
                            <a href="#contact"
                               @click="close()"
                               class="inline-flex items-center justify-center gap-2 rounded-2xl bg-ses-green text-white px-6 py-3 font-bold hover:opacity-95 transition">
                                <i class="fa-solid fa-paper-plane text-sm"></i> დაგვიკავშირდით
                            </a>

                            <button
                                    type="button"
                                    @click="close()"
                                    class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-300 bg-white px-6 py-3 font-semibold text-slate-800 hover:bg-slate-50 transition"
                            >
                                დახურვა
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
</section>

<script>
    function servicesUI() {
        return {
            open: false,
            service: null,

            openFromEl(el) {
                try {
                    const raw = el.dataset.service
                    if (!raw) return
                    this.service = JSON.parse(raw)
                    this.open = true
                    document.body.classList.add('no-scroll')
                } catch (e) {
                    console.error('Invalid service JSON', e)
                }
            },

            close() {
                this.open = false
                this.service = null
                document.body.classList.remove('no-scroll')
            }
        }
    }
</script>
