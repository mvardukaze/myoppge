<template>
  <v-container class="img-field">
    <!-- ============= SINGLE MODE (as-is) ============= -->
    <template style="max-width: 200px;" v-if="!props.multiple">
      <div class="single image-upload-wrapper" @click="openSingle">
        <v-img
            :src="singleSrc"
            class="uploaded-image"
            cover
            height="100%"
            :loading="uploading"
        >
          <template #sources>
            <div class="image-overlay">
              <v-icon size="30" color="white">mdi-camera-flip</v-icon>
              <p class="overlay-text">სურათის შეცვლა</p>
            </div>

            <v-overlay
                :model-value="uploading"
                contained
                class="align-center justify-center"
            >
              <v-progress-circular color="primary" indeterminate size="64" />
            </v-overlay>
            <v-btn
                v-if="modelValueSingle && !readonly"
                icon="mdi-close"
                size="small"
                class="single-remove"
                color="error"
                variant="elevated"
                @click.stop="removeSingle"
            />
          </template>

          <template #error>
            <div class="empty-state">
              <v-avatar size="90" color="grey-lighten-3" class="upload-icon">
                <v-icon size="48" color="grey-darken-1">mdi-camera-plus</v-icon>
              </v-avatar>
              <template v-if="readonly">
                <p class="upload-text mt-4">ატვირთვა გამორთულია</p>

              </template>
              <template v-else>
                <p class="upload-text mt-4">სურათის ატვირთვა</p>
                <p class="upload-hint">დააჭირეთ ატვირთვისთვის</p>
              </template>


              <v-overlay
                  :model-value="uploading"
                  contained
                  class="align-center justify-center"
              >
                <v-progress-circular color="primary" indeterminate size="48" />
              </v-overlay>
            </div>
          </template>
        </v-img>

        <!-- delete single -->

      </div>

      <input
          type="file"
          class="d-none"
          ref="singleFile"
          accept="image/*"
          @change="onSingleFile"
      />
    </template>

    <!-- ============= MULTIPLE MODE (max 5) ============= -->
    <template v-else>
      <div class="multi-header">
        <div class="multi-title">სურათები</div>
        <div class="multi-hint">{{ items.length }}/{{ props.max }}</div>
      </div>

      <!-- Draggable grid -->
      <Draggable
          v-model="items"
          item-key="__key"
          class="grid"
          :animation="180"
          handle=".drag-handle"
          @end="normalizeOrder"
      >
        <template #item="{ element, index }">
          <div class="tile">
            <div class="image-upload-wrapper tile-wrap">
              <v-img
                  :src="baseUrl + element.url"
                  class="uploaded-image"
                  cover

                  :loading="uploading && activeIndex === index"
                  @click="openReplace(index)"
              >
                <template #sources>
                  <div class="image-overlay">
                    <v-icon size="26" color="white">mdi-camera-flip</v-icon>
                    <p class="overlay-text">შეცვლა</p>
                  </div>

                  <v-overlay
                      :model-value="uploading && activeIndex === index"
                      contained
                      class="align-center justify-center"
                  >
                    <v-progress-circular color="primary" indeterminate size="54" />
                  </v-overlay>
                </template>

                <template #error>
                  <div class="empty-state">
                    <p class="upload-text">ვერ ჩაიტვირთა</p>
                    <p class="upload-hint">დააჭირეთ ჩანაცვლებისთვის</p>
                  </div>
                </template>
              </v-img>

              <!-- actions -->
              <div class="tile-actions">
                <v-btn
                    icon="mdi-swap-horizontal"
                    size="x-small"
                    variant="elevated"
                    class="action-btn"
                    @click.stop="openReplace(index)"
                    title="შეცვლა"
                />
                <v-btn
                    icon="mdi-delete"
                    size="x-small"
                    variant="elevated"
                    color="error"
                    class="action-btn"
                    @click.stop="removeAt(index)"
                    title="წაშლა"
                />
                <v-btn
                    icon="mdi-drag"
                    size="x-small"
                    variant="elevated"
                    class="action-btn drag-handle"
                    title="გადალაგება"
                />
              </div>
            </div>
          </div>
        </template>

        <!-- Add tile -->
        <template #footer>
          <div v-if="canAdd" class="tile">
            <div class="image-upload-wrapper tile-wrap add-tile" @click="openAdd">
              <div class="add-inner">
                <v-icon size="40">mdi-plus</v-icon>
                <div class="add-text">დამატება</div>
                <div class="add-sub">არჩიეთ {{ remaining }}-მდე</div>
              </div>

              <v-overlay
                  :model-value="uploading && activeIndex === -1"
                  contained
                  class="align-center justify-center"
              >
                <v-progress-circular color="primary" indeterminate size="54" />
              </v-overlay>
            </div>
          </div>
        </template>
      </Draggable>

      <input
          type="file"
          class="d-none"
          ref="multiFile"
          accept="image/*"
          :multiple="true"
          @change="onMultiFiles"
      />
      <input
          type="file"
          class="d-none"
          ref="replaceFile"
          accept="image/*"
          @change="onReplaceFile"
      />
    </template>
  </v-container>
</template>

<script setup>
import { computed, ref, watch } from "vue";
import Draggable from "vuedraggable";
import http from "@/services/Http.js";

const props = defineProps({
  multiple: { type: Boolean, default: false },
  readonly:{ type: Boolean, default: false  },
  max: { type: Number, default: 5 },
});

// v-model (single: string) OR (multiple: array of objects)
const model = defineModel();

const baseUrl = "https://my.oop.ge";
const uploading = ref(false);

// -------------------- SINGLE --------------------
const singleFile = ref(null);

const modelValueSingle = computed(() => String(model.value ?? "").trim());

const singleSrc = computed(() => {

  return baseUrl + modelValueSingle.value;
});

function openSingle() {
  if(props.readonly) return;
  singleFile.value?.click();
}

function removeSingle() {
  model.value = "";
}

async function onSingleFile(e) {
  const input = e.target;
  const f = input?.files?.[0];
  if (!f) return;

  uploading.value = true;
  try {
    const uploaded = await uploadOne(f);
    model.value = uploaded.url; // single stores just url/path string
  } catch (err) {
    console.error("Upload failed:", err);
  } finally {
    uploading.value = false;
    if (input) input.value = "";
  }
}

// -------------------- MULTIPLE --------------------
const multiFile = ref(null);
const replaceFile = ref(null);

const activeIndex = ref(null); // -1 = add tile, >=0 = replace index

// internal list (always normalized, sorted by order)
const items = computed({
  get() {
    const arr = Array.isArray(model.value) ? model.value : [];
    // sort + attach stable key for draggable
    const sorted = [...arr].sort((a, b) => (a.order ?? 0) - (b.order ?? 0));
    return sorted.map((it, i) => ({
      id: it.id ?? null,
      url: it.path ?? it.url ?? "",
      order: it.order ?? i + 1,
      __key: String(it.id ?? `${it.url}-${it.order ?? i}`),
    }));
  },
  set(v) {
    // strip __key, keep {id,url,order}
    const clean = (v || []).map((it, idx) => ({
      id: it.id ?? null,
      url:  it.path ?? it.url ?? "",
      order: idx + 1,
    }));
    model.value = clean;
  },
});

const remaining = computed(() => Math.max(0, props.max - items.value.length));
const canAdd = computed(() => remaining.value > 0);

function openAdd() {
  if (!canAdd.value) return;
  activeIndex.value = -1;
  multiFile.value?.click();
}

function openReplace(i) {
  activeIndex.value = i;
  replaceFile.value?.click();
}

function removeAt(i) {
  const arr = [...items.value];
  arr.splice(i, 1);
  items.value = arr; // setter will normalize order
}

function normalizeOrder() {
  // after drag end, computed setter already normalizes
  items.value = [...items.value];
}

async function onMultiFiles(e) {
  const input = e.target;
  const files = Array.from(input?.files ?? []);
  if (!files.length) return;

  // respect remaining slots
  const toUpload = files.slice(0, remaining.value);
  if (!toUpload.length) {
    input.value = "";
    return;
  }

  uploading.value = true;
  activeIndex.value = -1;

  try {
    const uploadedAll = [];
    for (const f of toUpload) {
      // backend assumed: single-file endpoint per request
      uploadedAll.push(await uploadOne(f));
    }

    const arr = [...items.value].map(({ id, url,name, order }) => ({ id, url, name, order }));
    for (const up of uploadedAll) {
      arr.push({
        id: up.id ?? null,
        name: up.name,
        url: up.url,
        order: arr.length + 1,
      });
    }
    model.value = arr; // persist
  } catch (err) {
    console.error("Multi upload failed:", err);
  } finally {
    uploading.value = false;
    activeIndex.value = null;
    if (input) input.value = "";
  }
}

async function onReplaceFile(e) {
  const input = e.target;
  const f = input?.files?.[0];
  if (!f) return;

  const i = Number(activeIndex.value);
  if (!Number.isFinite(i) || i < 0) {
    input.value = "";
    return;
  }

  uploading.value = true;
  try {
    const up = await uploadOne(f);

    const arr = [...items.value].map(({ id, url, order }) => ({ id, url, order }));
    if (arr[i]) {
      arr[i].url = up.url;
      // სურვილისამებრ: id-საც შეცვლი თუ backend ახალი id-ს აბრუნებს
      if (up.id != null) arr[i].id = up.id;
    }
    model.value = arr;
  } catch (err) {
    console.error("Replace failed:", err);
  } finally {
    uploading.value = false;
    activeIndex.value = null;
    if (input) input.value = "";
  }
}

// -------------------- Upload helper --------------------
// Assumption: endpoint accepts 1 file and returns { data: { url, id } } OR { url, id }
async function uploadOne(file) {
  const formData = new FormData();
  formData.append("photo", file);

  const res = await http.post("upload", formData, {
    headers: { "Content-Type": "multipart/form-data" },
  });

  const url = (res?.path || res?.data?.url || res?.url) ;
  const name = res?.data?.name || res?.name;
  const id = res?.data?.id || res?.id;

  if (!url) throw new Error("Upload response missing url");
  return { url, id,  name};
}

// Safety: if someone flips multiple prop runtime, normalize model
watch(
    () => props.multiple,
    (m) => {
      if (m) {
        if (!Array.isArray(model.value)) model.value = [];
      } else {
        if (Array.isArray(model.value)) model.value = "";
      }
    },
    { immediate: true }
);
</script>

<style scoped>
.img-field {
  padding: 10px;
  max-width: 600px;
}

/* ===== shared wrapper ===== */
.image-upload-wrapper {
  aspect-ratio: 1/1;
  min-height: 100px;
  position: relative;
  border-radius: 12px;
  overflow: hidden;
  cursor: pointer;
  transition: all 0.3s ease;
}
.single.image-upload-wrapper{
  aspect-ratio: 16/9;
}

.image-upload-wrapper:hover {
  transform: scale(1.01);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

.uploaded-image {
  border-radius: 12px;
  position: relative;
  height: 100%;
}

/* overlay only on sources */
.image-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.45);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.2s ease;
  pointer-events: none;
}

.image-upload-wrapper:hover .image-overlay {
  opacity: 1;
}

.overlay-text {
  color: white;
  font-size: 14px;
  font-weight: 600;
  margin-top: 6px;
  margin-bottom: 0;
}

/* empty state */
.empty-state {
  aspect-ratio: 16/9;
  width: 100%;
  border: 2px dashed #ccc;
  border-radius: 12px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
  transition: all 0.3s ease;
  position: relative;
}

.empty-state:hover {
  border-color: #1976d2;
  background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
}

.upload-icon {
  transition: all 0.3s ease;
}

.upload-text {
  font-size: 16px;
  font-weight: 700;
  color: #424242;
  margin-bottom: 4px;
}
.upload-hint {
  font-size: 13px;
  color: #757575;
  margin: 0;
}

:deep(.v-img__error) {
  border-radius: 12px;
}

/* ===== SINGLE delete button ===== */
.single-remove {
  position: absolute;
  top: 10px;
  right: 10px;
  z-index: 5;
}

/* ===== MULTI layout ===== */
.multi-header {
  display: flex;
  align-items: baseline;
  justify-content: space-between;
  margin-bottom: 10px;
}
.multi-title {
  font-weight: 700;
  font-size: 16px;
}
.multi-hint {
  font-size: 13px;
  color: #777;
}

.grid {
  display: flex;
  gap: 12px;
  flex-direction: row;
  justify-content: space-around;
  flex-wrap: wrap;
}

.tile {
  max-width: 130px;
  max-width: 160px;
  width: 100%;
}
/* actions on top-right */
.tile-actions {
  position: absolute;
  top: 8px;
  right: 8px;
  display: flex;
  gap: 6px;
  z-index: 6;
}
.action-btn {
  backdrop-filter: blur(6px);
}

/* add tile */
.add-tile {
  border: 2px dashed #c8d3df;
  background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
}
.add-tile:hover {
  border-color: #1976d2;
  background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
}
.add-inner {
  height: 100%;
  display: grid;
  place-items: center;
  text-align: center;
  padding: 16px;
}
.add-text {
  font-weight: 800;
  margin-top: 6px;
}
.add-sub {
  font-size: 12px;
  color: #666;
  margin-top: 2px;
}
</style>
