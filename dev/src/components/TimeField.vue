<script setup>
import { computed, reactive, watch, onMounted, onBeforeUnmount } from "vue";

const $props = defineProps({

  seconds: { type: Boolean, default: false },
});
const $dialog = defineModel('dialog', { default: false });
const $model = defineModel({ default: "00:00" });

/** 1) ველების რიგი */
const order = ["h1", "h2", "m1", "m2"];

/** 2) კლავიატურის ლეიაუთი */
const keypadRows = [
  [
    { type: "digit", value: 1, label: "1" },
    { type: "digit", value: 2, label: "2" },
    { type: "digit", value: 3, label: "3" },
  ],
  [
    { type: "digit", value: 4, label: "4" },
    { type: "digit", value: 5, label: "5" },
    { type: "digit", value: 6, label: "6" },
  ],
  [
    { type: "digit", value: 7, label: "7" },
    { type: "digit", value: 8, label: "8" },
    { type: "digit", value: 9, label: "9" },
  ],
  [
    { type: "action", action: "backspace", label: "⌫" },
    { type: "digit", value: 0, label: "0" },
    { type: "action", action: "ok", label: "OK" },
  ],
];

/** model -> digits */
function parseModel(v) {
  const s = String(v ?? "00:00");
  const m = s.match(/^(\d)(\d):(\d)(\d)$/);
  if (!m) return { h1: 0, h2: 0, m1: 0, m2: 0 };
  return {
    h1: Number(m[1]),
    h2: Number(m[2]),
    m1: Number(m[3]),
    m2: Number(m[4]),
  };
}

/** რეაქტიული digits */
const data = reactive(parseModel($model.value));

/** model sync (თუ გარედან შეიცვალა) */
watch(
    () => $model.value,
    (v) => {
      const p = parseModel(v);
      data.h1 = p.h1;
      data.h2 = p.h2;
      data.m1 = p.m1;
      data.m2 = p.m2;
    }
);

const opt = reactive({ active: "h1" });

function setActive(key) {
  opt.active = key;
}

function nextActive(key) {
  const idx = order.indexOf(key);
  return order[(idx + 1) % order.length];
}

function prevActive(key) {
  const idx = order.indexOf(key);
  return order[(idx - 1 + order.length) % order.length];
}

/** digits enable rules */
function is_enable_digit(i) {
  const a = opt.active;
  if (!a) return false;

  if (a === "h1") return i >= 0 && i <= 2;

  if (a === "h2") {
    if (data.h1 === 2) return i >= 0 && i <= 3; // 20..23
    return i >= 0 && i <= 9;
  }

  if (a === "m1") return i >= 0 && i <= 5;
  if (a === "m2") return i >= 0 && i <= 9;

  return false;
}

function changeDigit(i) {
  if (!opt.active) return;
  if (!is_enable_digit(i)) return;

  data[opt.active] = i;

  if (opt.active === "m2") {

    opt.active = "h1";
    return;
  }

  opt.active = nextActive(opt.active);
}

function backspace() {
  if (!opt.active) {
    opt.active = "h1";
    return;
  }
  const prev = prevActive(opt.active);
  opt.active = prev;
  data[prev] = 0;
}

const time = computed(() => `${data.h1}${data.h2}:${data.m1}${data.m2}`);

function done() {
  // აქ ვაბრუნებთ მოდელში
  $model.value = time.value;
  $dialog.value = false;
}

/** OK / Backspace */
function onAction(action) {
  if (action === "backspace") return backspace();
  if (action === "ok") return done();
}

/** UI: აქტიური ველის სტილი */
function fieldClass(key) {
  return { "active-field": opt.active === key };
}

/** keypad buttons disable */
function isKeyDisabled(key) {
  if (key.type === "digit") return !is_enable_digit(key.value);
  if (key.type === "action" && key.action === "ok") return false;
  return false;
}

/** ===== Keyboard support ===== */
function handleKeydown(e) {
  // არ ჩაერიოს თუ modifier-ებია
  if (e.ctrlKey || e.metaKey || e.altKey) return;

  // digits
  if (e.key >= "0" && e.key <= "9") {
    const d = Number(e.key);
    if (is_enable_digit(d)) {
      e.preventDefault();
      changeDigit(d);
    }
    return;
  }

  // backspace / delete
  if (e.key === "Backspace" || e.key === "Delete") {
    e.preventDefault();
    backspace();
    return;
  }

  // enter -> ok
  if (e.key === "Enter") {
    e.preventDefault();
    done();
    return;
  }

  // navigation
  if (e.key === "ArrowLeft") {
    e.preventDefault();
    opt.active = prevActive(opt.active);
    return;
  }
  if (e.key === "ArrowRight") {
    e.preventDefault();
    opt.active = nextActive(opt.active);
    return;
  }

  // tab cycles (shift+tab reverse)
  if (e.key === "Tab") {
    e.preventDefault();
    opt.active = e.shiftKey ? prevActive(opt.active) : nextActive(opt.active);
    return;
  }
}

onMounted(() => window.addEventListener("keydown", handleKeydown));
onBeforeUnmount(() => window.removeEventListener("keydown", handleKeydown));
</script>

<template>
    <v-container  max-width="300px">
      <v-card class="pa-2"style="background: #202020">
      <!-- display -->
      <div >
        <div class="d-flex flex-row ma-2 pa-2 ga-2" style="background: #69552d; border: solid 3px #121717" >
          <template v-for="(key, i) in order" :key="key">

            <div
                class="time-cell flex-1-1-100"
                :class="{ active: opt.active === key }"
                @click="setActive(key)"
            >
              {{ data[key] }}
            </div>


            <div v-if="i === 1"  style="font-size: 28px; font-family: 'DS-Digital'"> : </div>
          </template>
        </div>
      </div>



      <!-- keypad -->
      <div class="keypad">
        <v-row v-for="(row, r) in keypadRows" :key="r" class="mb-2">
          <v-col v-for="(k, c) in row" :key="c" cols="4">
            <v-btn
                block
                size="large"
                class="keypad-btn"
                :class="{
    'keypad-ok': k.type === 'action' && k.action === 'ok',
    'keypad-back': k.type === 'action' && k.action === 'backspace',
  }"
                :disabled="isKeyDisabled(k)"
                @click="k.type === 'digit' ? changeDigit(k.value) : onAction(k.action)"
            >
              {{ k.label }}
            </v-btn>

          </v-col>
        </v-row>
      </div>
      </v-card>
    </v-container>


</template>

<style scoped>
@font-face {
  font-family: 'DS-Digital';
  src: url('@/assets/DS-DIGIB.TTF') format('truetype');
  font-weight: normal;
  font-style: normal;
}

/* ===== Display digits (LCD cells) ===== */


.time-cell {
  display: block;
  position: relative;
  font-family: 'DS-Digital', monospace;
  font-variant-numeric: tabular-nums lining-nums;
  color: #e6f7f1;
  background: rgba(27, 34, 34, 0.61);
  text-shadow:
      0 0 4px rgba(180,255,230,.6),
      0 0 10px rgba(100,255,220,.3);

 ;
  border-radius: 6px;  height: 44px;
  min-width: 34px;
  display: flex;

  align-items: center;
  justify-content: center;

  font-size: 30px;
  font-weight: 600;

  border: 1px solid rgba(180,255,230,.25);

  cursor: pointer;
  user-select: none;

  transition:
      box-shadow .12s ease,
      text-shadow .12s ease,
      opacity .12s ease,
      transform .08s ease;
}

.time-cell:not(.active) {
  opacity: .86;
}

.time-cell.active {
  opacity: 1;

  box-shadow:
      inset 0 0 0 1px rgba(180,255,230,.45),
      0 0 6px rgba(180,255,230,.55),
      0 0 14px rgba(100,255,220,.4);

  text-shadow:
      0 0 6px rgba(200,255,240,.95),
      0 0 14px rgba(120,255,220,.7);

  transform: scale(1.05);
}

.time-cell.active::after {
  content: '';
  position: absolute;
  bottom: 4px;
  width: 14px;
  height: 2px;

  background: rgba(180,255,230,.95);
  box-shadow: 0 0 6px rgba(180,255,230,.9);

  animation: blink 1s steps(1) infinite;
}

@keyframes blink {
  50% { opacity: 0; }
}

/* ===== Keypad wrapper (optional) ===== */
.keypad {
  padding: 10px;
  border-radius: 12px;
  background: #121717; /* matches LCD vibe */
  border: 1px solid rgba(180,255,230,.12);
  box-shadow:
      inset 0 0 0 1px rgba(0,0,0,.35),
      0 8px 24px rgba(0,0,0,.25);
}

/* ===== Keypad buttons ===== */
.keypad-btn {
  font-family: 'DS-Digital', monospace;
  font-variant-numeric: tabular-nums lining-nums;

  height: 54px !important;
  border-radius: 12px !important;

  background: linear-gradient(180deg, #1f2a2a 0%, #151d1d 100%) !important;
  border: 1px solid rgba(180,255,230,.14) !important;

  color: rgba(230,247,241,.92) !important;
  text-shadow:
      0 0 3px rgba(180,255,230,.35),
      0 0 10px rgba(100,255,220,.18) !important;

  box-shadow:
      inset 0 0 0 1px rgba(0,0,0,.25),
      0 6px 16px rgba(0,0,0,.22);

  transition:
      transform .06s ease,
      box-shadow .12s ease,
      filter .12s ease,
      opacity .12s ease;
}

/* hover/press */
.keypad-btn:hover {
  filter: brightness(1.08);
}

.keypad-btn:active {
  transform: translateY(1px) scale(.99);
  box-shadow:
      inset 0 0 0 1px rgba(0,0,0,.35),
      0 3px 10px rgba(0,0,0,.22);
}

/* disabled */
.keypad-btn.v-btn--disabled {
  opacity: .35 !important;
  filter: grayscale(.2);
  text-shadow: none !important;
  box-shadow: none !important;
}

/* OK and Backspace accents (still in theme) */
.keypad-btn.keypad-ok {
  border-color: rgba(120,255,220,.32) !important;
  box-shadow:
      inset 0 0 0 1px rgba(120,255,220,.12),
      0 0 10px rgba(120,255,220,.18),
      0 6px 16px rgba(0,0,0,.22);
}

.keypad-btn.keypad-back {
  border-color: rgba(255,200,120,.28) !important;
  box-shadow:
      inset 0 0 0 1px rgba(255,200,120,.10),
      0 0 10px rgba(255,200,120,.14),
      0 6px 16px rgba(0,0,0,.22);
}
</style>


