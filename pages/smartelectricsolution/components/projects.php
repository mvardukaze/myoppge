<?php
// --------- DATA (Example) ---------


global $db, $projects, $params;


// --------- STATUS MAP ---------
$statusMap = [
    'done' => [
        'label' => 'დასრულებული',
        'class' => '',
        'style' => 'background-color: ' . htmlspecialchars($params['primaryColor']) . '; color: white;',
    ],
    'in_progress' => [
        'label' => 'მიმდინარე',
        'class' => 'animate-pulse',
        'style' => 'background-color: ' . htmlspecialchars($params['buttonColor']) . '; color: white;',
    ],
];

$initialCount = 4;
?>

<!-- Needed once (put in <head> ideally) -->
<style>[x-cloak]{display:none!important;}</style>

<section id="projects" class="" style="background-color: <?= htmlspecialchars($params['backgroundColor']) ?>; border-top: 1px solid <?= htmlspecialchars($params['primaryColor']) ?>;">
    <div class="mx-auto max-w-7xl px-4 py-14 lg:py-20">

        <!-- Header -->
        <div class="flex items-end justify-between gap-6">
            <div data-aos="fade-up">
                <h2 class="text-2xl sm:text-3xl font-semibold tracking-tight" style="color: <?= htmlspecialchars($params['headerColor']) ?>;">პროექტები</h2>
                <p class="mt-2" style="color: <?= htmlspecialchars($params['textColor']) ?>;">რამდენიმე ტიპური სამუშაო (ფოტოები — დემო, picsum).</p>
            </div>

            <div class="hidden sm:block text-sm" data-aos="fade-up" style="color: <?= htmlspecialchars($params['textColor']) ?>;">
        <span class="inline-flex items-center gap-2">
          <span class="h-2 w-2 rounded-full animate-pulse" style="background-color: <?= htmlspecialchars($params['primaryColor']) ?>;"></span>
          Real photos — მოგვიანებით ჩაანაცვლე
        </span>
            </div>
        </div>

        <!-- Projects + Modal wrapper -->
        <div x-data="project()" class="mt-10">

            <!-- Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <?php foreach ($projects as $i => $card):
                    $status = $statusMap[$card['status']] ?? $statusMap['done'];
                    $firstImg = $card['photos'][0] ?? 'https://picsum.photos/seed/fallback/1200/800';

                    $payload = htmlspecialchars(json_encode([
                        'title'        => $card['title'] ?? '',
                        'subtitle'     => $card['subtitle'] ?? '',
                        'status_label' => $status['label'],
                        'status_class' => $status['class'],
                        'desc'         => $card['desc'] ?? '',
                        'location'     => $card['location'] ?? '',
                        'date'         => $card['date'] ?? '',
                        'photos'       => $card['photos'] ?? [],
                    ], JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8');
                    ?>

                    <div x-show="expanded || <?= (int)$i ?> < <?= (int)$initialCount ?>" x-transition x-cloak>
                        <button
                            type="button"
                            @click="openFromEl($el)"
                            data-card='<?= $payload ?>'
                            class="text-left group relative flex flex-col w-full rounded-3xl overflow-hidden transition-all hover:shadow-xl" style="border: 1px solid <?= htmlspecialchars($params['primaryColor']) ?>; background-color: <?= htmlspecialchars($params['backgroundColor']) ?>;"
                            data-aos="zoom-in"
                        >
                            <!-- STATUS -->
                            <span class="absolute top-4 left-4 z-10 rounded-full px-3 py-1 text-xs font-semibold <?= $status['class'] ?>" style="<?= $status['style'] ?>">
                <?= htmlspecialchars($status['label']) ?>
              </span>

                            <!-- IMAGE -->
                            <div class="overflow-hidden h-44">
                                <img
                                    src="<?= htmlspecialchars($firstImg) ?>"
                                    alt="<?= htmlspecialchars($card['title'] ?? '') ?>"
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                                    loading="lazy"
                                >
                            </div>

                            <!-- CONTENT -->
                            <div class="p-5">
                                <div class="font-semibold text-sm transition-colors" style="color: <?= htmlspecialchars($params['headerColor']) ?>;" onmouseover="this.style.color='<?= htmlspecialchars($params['primaryColor']) ?>'" onmouseout="this.style.color='<?= htmlspecialchars($params['headerColor']) ?>'">
                                    <?= htmlspecialchars($card['title'] ?? '') ?>
                                </div>
                                <div class="text-xs mt-1" style="color: <?= htmlspecialchars($params['textColor']) ?>;">
                                    <?= htmlspecialchars($card['subtitle'] ?? '') ?>
                                </div>
                            </div>
                        </button>
                    </div>

                <?php endforeach; ?>

            </div>

            <!-- Toggle -->
            <?php if (count($projects) > $initialCount): ?>
                <div class="mt-10 flex justify-center">
                    <button
                        type="button"
                        @click="toggleExpand()"
                        class="group inline-flex items-center gap-2 rounded-full px-6 py-3 text-sm font-semibold shadow-sm hover:shadow-md focus:outline-none focus:ring-4 transition-all" style="border: 1px solid <?= htmlspecialchars($params['primaryColor']) ?>; background-color: <?= htmlspecialchars($params['backgroundColor']) ?>; color: <?= htmlspecialchars($params['textColor']) ?>; --tw-ring-color: <?= htmlspecialchars($params['primaryColor']) ?>20;"
                    >
                        <span x-text="expanded ? 'ნაკლების ნახვა' : 'ყველას ნახვა'"></span>

                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 text-slate-700 transition-transform"
                              :class="expanded ? 'rotate-180' : ''">
            <i class="fa-solid fa-chevron-down text-xs"></i>
          </span>
                    </button>
                </div>
            <?php endif; ?>

            <!-- MODAL -->
            <div
                x-show="open"
                x-cloak
                @keydown.escape.window="closeModal()"
                @keydown.arrow-left.window="open && prevImg()"
                @keydown.arrow-right.window="open && nextImg()"
                class="fixed inset-0 z-[999] flex items-center justify-center p-4"
                aria-modal="true"
                role="dialog"
            >
                <!-- Backdrop -->
                <div class="absolute inset-0 bg-slate-900/60" @click="closeModal()"></div>

                <!-- Panel -->
                <div x-transition class="relative w-full max-w-4xl overflow-hidden rounded-3xl bg-white shadow-2xl">

                    <!-- Close -->
                    <button
                        type="button"
                        @click="closeModal()"
                        class="absolute right-4 top-4 z-20 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/90 text-slate-700 shadow hover:bg-white"
                        aria-label="Close"
                    >
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                    <!-- IMAGE AREA -->
                    <div class="relative bg-slate-100">
                        <div class="h-64 sm:h-96 overflow-hidden">
                            <img
                                x-show="card && hasImages()"
                                :src="currentImg()"
                                class="h-full w-full object-cover"
                            />

                        </div>

                        <!-- Prev/Next -->
                        <button
                            type="button"
                            x-show="card?.photos?.length > 1"
                            @click="prevImg()"
                            class="absolute left-3 top-1/2 -translate-y-1/2 z-10 inline-flex h-11 w-11 items-center justify-center rounded-full bg-white/90 text-slate-800 shadow hover:bg-white"
                            aria-label="Previous photo"
                        >
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>

                        <button
                            type="button"
                            x-show="card?.photos?.length > 1"
                            @click="nextImg()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 z-10 inline-flex h-11 w-11 items-center justify-center rounded-full bg-white/90 text-slate-800 shadow hover:bg-white"
                            aria-label="Next photo"
                        >
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>

                        <!-- Counter -->
                        <div
                            x-show="card?.photos?.length > 1"
                            class="absolute bottom-3 right-3 z-10 rounded-full bg-slate-900/70 px-3 py-1 text-xs font-semibold text-white"
                        >
                            <span x-text="(imgIndex + 1)"></span>/<span x-text="card?.photos?.length"></span>
                        </div>
                    </div>

                    <!-- Thumbnails -->
                    <div x-show="card?.images?.length > 1" class="px-6 pt-4">
                        <div class="flex gap-3 overflow-x-auto pb-2">
                            <template x-for="(img, i) in card.photos" :key="img + i">
                                <button
                                    type="button"
                                    @click="setImg(i)"
                                    class="shrink-0 rounded-2xl border overflow-hidden"
                                    :class="i === imgIndex ? 'border-emerald-500 ring-4 ring-emerald-200' : 'border-slate-200 hover:border-slate-300'"
                                    aria-label="Select photo"
                                >
                                    <img :src="img" class="h-16 w-24 object-cover" alt="">
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6 sm:p-8">
                        <div class="flex flex-wrap items-center gap-3">
              <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold"
                    :class="card?.status_class"
                    x-text="card?.status_label"></span>

                            <span class="text-xs text-slate-500" x-show="card?.date" x-text="card?.date"></span>
                            <span class="text-xs text-slate-500" x-show="card?.location" x-text="card?.location"></span>
                        </div>

                        <h3 class="mt-3 text-2xl font-semibold tracking-tight text-slate-900" x-text="card?.title"></h3>
                        <p class="mt-1 text-sm text-slate-600" x-text="card?.subtitle"></p>

                        <p class="mt-4 text-slate-700 leading-relaxed whitespace-pre" x-text="card?.desc"></p>

                        <div class="mt-6 flex flex-col sm:flex-row gap-3">
                            <a href="#contact"
                               @click="closeModal()"
                               class="inline-flex items-center justify-center gap-2 rounded-2xl bg-ses-green text-white px-6 py-3 font-bold hover:opacity-95 transition">
                                <i class="fa-solid fa-paper-plane text-sm"></i> მომწერე ამ პროექტზე
                            </a>

                            <button
                                type="button"
                                @click="closeModal()"
                                class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-300 bg-white px-6 py-3 font-semibold text-slate-800 hover:bg-slate-50 transition"
                            >
                                დახურვა
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- CTA -->
        <div class="mt-16 rounded-[2.5rem] bg-slate-900 text-white p-8 sm:p-12 overflow-hidden relative shadow-2xl" data-aos="fade-up">
            <div class="absolute -right-20 -top-20 h-80 w-80 rounded-full bg-emerald-500/10 blur-[80px]"></div>
            <div class="absolute -left-20 -bottom-20 h-80 w-80 rounded-full bg-blue-500/10 blur-[80px]"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
                <div class="max-w-2xl">
                    <span class="inline-block px-3 py-1 rounded-full bg-white/10 text-xs font-medium text-emerald-400 mb-4">სწრაფი გამოთვლა</span>
                    <h3 class="text-3xl sm:text-4xl font-semibold tracking-tight">გინდა სამუშაოს შეფასება?</h3>
                    <p class="mt-4 text-lg text-slate-400 leading-relaxed">
                        მოგვწერე რა გჭირდება და დაგიბრუნებთ შეთავაზებას:
                        <span class="text-white">მასალები, ვადები, სამუშაოს მოცულობა.</span>
                    </p>
                </div>

                <a href="#contact"
                   class="shrink-0 inline-flex items-center justify-center gap-3 rounded-2xl bg-ses-green text-white px-8 py-4 font-bold text-lg transition-transform hover:scale-105 active:scale-95 shadow-lg shadow-emerald-500/20">
                    <i class="fa-solid fa-calculator text-sm"></i> ფასის მიღება
                </a>
            </div>
        </div>

    </div>
</section>

<script>
    function project() {
        return {
            expanded: false,
            open: false,
            card: null,
            imgIndex: 0,
            toggleExpand(){
               this.expanded=!this.expanded
            },
            openFromEl(el) {
                try {
                    const data = el.dataset.card
                    if (!data) return

                    this.card = JSON.parse(data)
                    this.imgIndex = 0
                    this.open = true
                    document.body.style.overflow = 'hidden'
                } catch (e) {
                    console.error('Invalid card JSON', e)
                }
            },

            closeModal() {
                this.open = false
                this.card = null
                this.imgIndex = 0
                document.body.style.overflow = ''
            },

            hasImages() {
                return Array.isArray(this.card?.photos) && this.card.photos.length > 0
            },

            currentImg() {
                if (!this.hasImages()) return ''
                return this.card.photos[this.imgIndex] ?? this.card.photos[0]
            },

            prevImg() {
                if (!this.hasImages()) return
                this.imgIndex =
                    (this.imgIndex - 1 + this.card.photos.length) %
                    this.card.photos.length
            },

            nextImg() {
                if (!this.hasImages()) return
                this.imgIndex =
                    (this.imgIndex + 1) %
                    this.card.photos.length
            },

            setImg(i) {
                if (!this.hasImages()) return
                this.imgIndex = i
            },
        }
    }

</script>
