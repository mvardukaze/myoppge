<?php
global $params, $services;
?>
<section id="contact" class="bg-white border-t border-slate-200">
    <div class="mx-auto max-w-7xl px-4 py-14 lg:py-20">
        <div class="grid lg:grid-cols-2 gap-10 items-start">
            <div data-aos="fade-up">
                <h2 class="text-2xl sm:text-3xl font-semibold">კონტაქტი</h2>
                <p class="mt-2 text-slate-600">
                    შეავსე ფორმა ან დაგვირეკე — გიპასუხებთ სწრაფად.
                </p>

                <div class="mt-6 space-y-3">
                    <a class="flex items-center gap-3 rounded-2xl border border-slate-200 p-4 hover:bg-slate-50" href="tel:<?= htmlspecialchars($params['phone']) ?>">
                        <div class="h-10 w-10 rounded-2xl bg-emerald-50 flex items-center justify-center">
                            <i class="fa-solid fa-phone text-ses-green"></i>
                        </div>
                        <div>
                            <div class="text-sm font-semibold">ტელეფონი</div>
                            <div class="text-sm text-slate-600"><?= htmlspecialchars($params['phone']) ?></div>
                        </div>
                    </a>

                    <a class="flex items-center gap-3 rounded-2xl border border-slate-200 p-4 hover:bg-slate-50" href="mailto:<?= htmlspecialchars($params['email']) ?>">
                        <div class="h-10 w-10 rounded-2xl bg-emerald-50 flex items-center justify-center">
                            <i class="fa-solid fa-envelope text-ses-green"></i>
                        </div>
                        <div>
                            <div class="text-sm font-semibold">ელ-ფოსტა</div>
                            <div class="text-sm text-slate-600"><?= htmlspecialchars($params['email']) ?></div>
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
                        <a class="h-11 w-11 rounded-2xl border border-slate-200 bg-white flex items-center justify-center hover:bg-slate-50" href="" aria-label="WhatsApp">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                    </div>

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
                            <option value="">აირჩიეთ სერვისი</option>
                            <?php foreach ($services as $service): ?>
                                <option value="<?= htmlspecialchars($service['id'] ?? '') ?>">
                                    <?= htmlspecialchars($service['title'] ?? '') ?>
                                </option>
                            <?php endforeach; ?>
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
