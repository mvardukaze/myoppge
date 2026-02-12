<?php
global $params, $faq;
?>
<section id="faq" class="" style="background-color: <?= htmlspecialchars($params['backgroundColor']) ?>; border-top: 1px solid <?= htmlspecialchars($params['primaryColor']) ?>;">
    <div class="mx-auto max-w-7xl px-4 py-14 lg:py-20">
        <div data-aos="fade-up">
            <h2 class="text-2xl sm:text-3xl font-semibold" style="color: <?= htmlspecialchars($params['headerColor']) ?>;">ხშირად დასმული კითხვები</h2>
            <p class="mt-2" style="color: <?= htmlspecialchars($params['textColor']) ?>;">მოკლე პასუხები — სურვილისამებრ შეცვალე/დაამატე.</p>
        </div>

        <div class="mt-8 grid lg:grid-cols-2 gap-4">
            <?php
            $faqData = [
                ['q' => 'აკეთებთ თუ არა 3-ფაზიან სისტემებს?', 'a' => 'კი — ვასრულებთ L1/L2/L3 დატვირთვების სწორ განაწილებას, დაცვას და ტესტირებას.'],
                ['q' => 'დამიწების კონტური როდის არის აუცილებელი?', 'a' => 'უმეტეს ობიექტებზე უსაფრთხოებისთვის საჭიროა; დეტალები დამოკიდებულია ობიექტის ტიპზე და არსებული ქსელის მდგომარეობაზე.'],
                ['q' => 'სუსტი დენები რას მოიცავს?', 'a' => 'CCTV, ქსელი/ინტერნეტი, სიგნალიზაცია, დომოფონი და სხვა კომუნიკაციური სისტემები.'],
                ['q' => 'როგორ დავიწყოთ?', 'a' => 'დაგვიკავშირდი, მოგვაწოდე მისამართი/ფოტოები და მოთხოვნა — დაგიბრუნებთ შეფასებას და ვადებს.']
            ];

            // Use database data if available, otherwise fallback to default
            $displayData = !empty($faq) ? $faq : $faqData;

            foreach ($displayData as $index => $item):
                $question = isset($item['title']) ? $item['title'] : $item['q'];
                $answer = isset($item['detail']) ? $item['detail'] : $item['a'];
                $delay = ($index % 2) * 50; // 0 / 50
            ?>
            <div class="rounded-3xl p-6" style="border: 1px solid <?= htmlspecialchars($params['primaryColor']) ?>; background-color: <?= htmlspecialchars($params['backgroundColor']) ?>;" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
                <button class="w-full flex items-center justify-between text-left" @click="q<?= $index + 1 ?> = !q<?= $index + 1 ?>">
                    <span class="font-semibold" style="color: <?= htmlspecialchars($params['headerColor']) ?>;"><?= htmlspecialchars($question) ?></span>
                    <i class="fa-solid" :class="q<?= $index + 1 ?> ? 'fa-chevron-up' : 'fa-chevron-down'" style="color: <?= htmlspecialchars($params['primaryColor']) ?>;"></i>
                </button>
                <div class="mt-3 text-sm" x-show="q<?= $index + 1 ?>" x-transition style="color: <?= htmlspecialchars($params['textColor']) ?>;">
                    <?= htmlspecialchars($answer) ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('faq', () => {
        const data = {};
        <?php foreach ($displayData as $index => $item): ?>
        data.q<?= $index + 1 ?> = false;
        <?php endforeach; ?>
        return data;
    });
});
</script>
