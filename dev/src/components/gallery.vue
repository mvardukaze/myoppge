<script setup>
import {onMounted, ref} from "vue";
import http from "@/services/Http.js";

const $props = defineProps({
  id: String
});

const loaded = ref(false);
const photos = ref([]);
const uploading = ref(false);
const file = ref(null);

function upload(event) {
  const selectedFile = event.target.files[0];
  if (!selectedFile) return;

  const formData = new FormData();
  formData.append('photo', selectedFile);
  formData.append('project_id', $props.id);

  uploading.value = true;

  http.post(`projects/photos/${$props.id}`, formData, {
    headers: {
      'Content-Type': 'multipart/form-data'
    }
  }).then(res => {
    photos.value.push(res);
    file.value.value = '';
  }).catch(err => {
    console.error('Upload failed:', err);
  }).finally(() => {
    uploading.value = false;
  });
}

function open() {
  file.value.click();
}

function deletePhoto(photoId, index) {
  if (!confirm('დარწმუნებული ხართ, რომ გსურთ ფოტოს წაშლა?')) return;

  http.delete(`projects/photos/${photoId}`).then(() => {
    photos.value.splice(index, 1);
  }).catch(err => {
    console.error('Delete failed:', err);
  });
}

function load() {
  http.get(`projects/photos/${$props.id}`).then(res => {
    photos.value = res.items;
  }).finally(() => {
    loaded.value = true;
  });
}

onMounted(() => {
  load();
});
</script>

<template>
  <v-container v-if="loaded">
    <input
        type="file"
        @change="upload"
        hidden
        ref="file"
        accept="image/*"
    />

    <v-btn
        icon="mdi-plus"
        @click="open"
        :loading="uploading"
        :disabled="uploading"
        color="primary"
        class="mb-4"
    ></v-btn>

    <v-row>
      <v-col
          v-for="(photo, index) in photos"
          :key="photo.id || index"
          cols="12"
          sm="6"
          md="4"
      >
        <v-card class="photo-card">

          <v-img
              :src="`http://my.oop.ge/${photo.path}`"
              :alt="photo.name || 'Photo'"
              cover
              height="100"
              class="cursor-pointer"
          >
            <template v-slot:placeholder>
              <v-row
                  class="fill-height ma-0"
                  align="center"
                  justify="center"
              >
                <v-progress-circular
                    indeterminate
                    color="grey-lighten-5"
                ></v-progress-circular>
              </v-row>
            </template>
          </v-img>

          <v-card-actions class="justify-end pa-2">
            <v-btn
                icon="mdi-delete"
                size="small"
                color="error"
                variant="text"
                @click="deletePhoto(photo.id, index)"
            ></v-btn>
          </v-card-actions>
        </v-card>
      </v-col>

      <v-col v-if="photos.length === 0" cols="12">
        <v-alert
            type="info"
            variant="tonal"
            class="text-center"
        >
          ფოტოები ჯერ არ არის ატვირთული
        </v-alert>
      </v-col>
    </v-row>
  </v-container>

  <v-skeleton-loader
      v-else
      height="500"
      type="image, image, image"
  />
</template>

<style scoped>
.photo-card {
  transition: transform 0.2s;
}

.photo-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.cursor-pointer {
  cursor: pointer;
}
</style>
