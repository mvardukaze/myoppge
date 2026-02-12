<script setup>
import {onMounted, reactive, ref} from "vue";
import http from "@/services/Http.js";
import dateField from "./DatePicker.vue";
import ImgField from "@/components/imgField.vue";
import TimePicker from "@/components/TimePicker.vue";
import { VDateInput } from 'vuetify/labs/VDateInput'

const $props = defineProps({
  options: Object,
  open: Function,
  data: Array,
  fields: Array
});

const options = {
  load: ref(false),
  url:{
    list: $props.options.url.get ?? $props.options.url,
    save: $props.options.url.save ?? $props.options.url,
    del: $props.options.url.del ?? $props.options.url
  }
}

const fields = $props.fields.map(field=>{
  return {
    options: field.options,
    action: field.action,
    multiple: field.multiple,
    key: field.key,
    title: field.label ?? field.key,
    type: field.type ?? "text",
  }
});

fields.push({
  key: 'actions',
  title: '#',
  type: 'actions'
})

const items = ref($props.data);
const saving = ref(false);
const snackbar = reactive({
  visible: false,
  message: '',
  color: 'success'
});

function load(){
  if(options.url.list){
    options.load.value = false;
    http.get(options.url.list).then(res=>{
      items.value = res.items;
    }).catch(err=>{
      console.log(err);
      showSnackbar('შეცდომა მონაცემების ჩატვირთვისას', 'error');
    }).finally(()=>{
      options.load.value = true;
    })
  }
}

function save(){
  saving.value = true;
  const d = Object.assign({},edit.data.value);
  http.post(options.url.save,d).then(res=>{
    showSnackbar('მონაცემები წარმატებით შეინახა', 'success');
    load();
    edit.close();
  }).catch(err=>{
    console.log(err);
    showSnackbar('შეცდომა შენახვისას', 'error');
  }).finally(()=>{
    saving.value = false;
  })
}

function showSnackbar(message, color = 'success'){
  snackbar.message = message;
  snackbar.color = color;
  snackbar.visible = true;
}

const edit = {
  data:ref({}),
  open(r={}){
    edit.data.value = Object.assign({},r);
    edit.visible.value = true;
  },
  close(){
    if(!saving.value){
      edit.visible.value = false;
    }
  },
  visible: ref(false)
};

onMounted(()=>{
  load();
})
</script>

<template>
  <v-card class="elevation-4 rounded-lg overflow-hidden">
    <!-- Toolbar -->
    <v-toolbar color="primary" dark class="elevation-0">
      <v-toolbar-title class="text-h6 font-weight-bold">
        <v-icon class="mr-2">mdi-format-list-bulleted</v-icon>
        მონაცემები
      </v-toolbar-title>
      <v-spacer />
      <v-btn
          v-if="$props.options.add"
          @click="edit.open()"
          variant="elevated"
          color="white"
          class="text-primary font-weight-bold"
          prepend-icon="mdi-plus-circle"
      >
        დამატება
      </v-btn>
    </v-toolbar>

    <!-- Data Table -->
    <v-data-table
        v-if="options.load.value"
        height="500"
        fixed-header
        :headers="fields"
        :items="items"
        :items-per-page="10"
        class="elevation-0"
        hover
    >
      <template v-slot:top>
        <v-divider />
      </template>

      <template v-slot:item.photos="{item}">
        <v-img
            :src="'https://my.oop.ge'+ item.photos[0]?.path"
            height="60"
            width="60"
            class="rounded-lg my-2"
            cover
        >
          <template #error>
            <v-avatar
                color="grey-lighten-2"
                icon="mdi-image-off-outline"
                size="60"
                class="rounded-lg"
                @click="$props.open(item)"
            ></v-avatar>
          </template>
        </v-img>
      </template>

      <template v-slot:item.icon="{item}">
        <v-img
            :src="'https://my.oop.ge'+ item.icon"
            height="60"
            width="60"
            class="rounded-lg my-2"
            cover
        >
          <template #error>
            <v-avatar
                color="grey-lighten-2"
                icon="mdi-image-off-outline"
                size="60"
                class="rounded-lg"
            ></v-avatar>
          </template>
        </v-img>
      </template>

      <template v-slot:item.active="{item}">
        <v-chip
            :color="item.active == 1 ? 'success' : 'error'"
            variant="flat"
            size="small"
            class="font-weight-medium"
        >
          {{ item.active == 1 ? 'აქტიური' : 'გამორთული' }}
        </v-chip>
      </template>

      <template v-slot:item.actions="{item}">
        <v-btn
            color="primary"
            icon="mdi-pencil"
            variant="tonal"
            size="small"
            @click="edit.open(item)"
        ></v-btn>
      </template>

      <template v-slot:no-data>
        <div class="text-center pa-8">
          <v-icon size="64" color="grey-lighten-1">mdi-inbox</v-icon>
          <p class="text-h6 text-grey-darken-1 mt-4">მონაცემები არ არის</p>
        </div>
      </template>
    </v-data-table>

    <!-- Loading Skeleton -->
    <v-skeleton-loader
        v-else
        height="500"
        type="table"
    />
  </v-card>

  <!-- Edit Dialog -->
  <v-dialog
      v-model="edit.visible.value"
      max-width="900px"
      :persistent="saving"
      scrollable
  >
    <v-card class="rounded-xl elevation-12">
      <!-- Header -->
      <v-card-title class="d-flex align-center justify-space-between bg-gradient pa-6">
        <div class="d-flex align-center">
          <v-icon class="mr-3" color="white" size="28">mdi-pencil-box</v-icon>
          <span class="text-h5 font-weight-bold text-white">
            {{ edit.data.value.id ? 'რედაქტირება' : 'ახალი ჩანაწერი' }}
          </span>
        </div>
        <v-btn
            icon="mdi-close"
            variant="text"
            color="white"
            @click="edit.close()"
            :disabled="saving"
        />
      </v-card-title>

      <v-divider class="border-opacity-100" />

      <!-- Loading Overlay -->
      <v-overlay
          :model-value="saving"
          contained
          class="align-center justify-center"
          persistent
      >
        <div class="text-center">
          <v-progress-circular
              indeterminate
              size="64"
              width="6"
              color="primary"
          />
          <p class="text-h6 mt-4 text-white">მიმდინარეობს შენახვა...</p>
        </div>
      </v-overlay>

      <!-- Form Content -->
      <v-card-text class="pa-8" style="max-height: 600px;">
        <v-form @submit.prevent="save" ref="form">
          <v-row>
            <template v-for="field in fields" :key="field.key">
              <v-col cols="12" v-if="field.type !== 'actions'">
                <!-- Text Field -->
                <v-text-field
                    v-if="field.type === 'text'"
                    :label="field.title"
                    v-model="edit.data.value[field.key]"
                    variant="outlined"
                    density="comfortable"
                    color="primary"
                    hide-details="auto"
                    class="mb-3"
                    :disabled="saving"
                />

                <!-- Date Field -->
                <v-date-input
                    v-if="field.type === 'date'"

                    :label="field.title"
                    v-model="edit.data.value[field.key]"
                    variant="outlined"
                    density="comfortable"
                    color="primary"
                    hide-details="auto"
                    class="mb-3"
                    :disabled="saving"
                />

                <!-- Select Field -->
                <v-select
                    v-if="field.type === 'select'"
                    :label="field.title"
                    v-model="edit.data.value[field.key]"
                    :items="field.options"
                    item-title="title"
                    item-value="value"
                    variant="outlined"
                    density="comfortable"
                    color="primary"
                    hide-details="auto"
                    class="mb-3"
                    :disabled="saving"
                />

                <!-- Textarea (HTML) -->
                <v-textarea
                    v-if="field.type === 'html'"
                    :label="field.title"
                    v-model="edit.data.value[field.key]"
                    variant="outlined"
                    density="comfortable"
                    color="primary"
                    hide-details="auto"
                    rows="4"
                    auto-grow
                    class="mb-3"
                    :disabled="saving"
                />



                <!-- Image Field -->
                <imgField
                    v-if="field.type === 'img'"
                    :multiple="field.multiple"
                    :label="field.title"
                    v-model="edit.data.value[field.key]"
                    variant="outlined"
                    density="comfortable"
                    color="primary"
                    hide-details="auto"
                    class="mb-3"
                    :disabled="saving"
                />
              </v-col>
            </template>
          </v-row>
        </v-form>
      </v-card-text>

      <v-divider class="border-opacity-100" />

      <!-- Actions -->
      <v-card-actions class="pa-6 bg-grey-lighten-5">
        <v-spacer />
        <v-btn
            variant="outlined"
            color="grey-darken-1"
            size="large"
            class="px-8 text-none font-weight-bold"
            @click="edit.close()"
            :disabled="saving"
        >
          <v-icon class="mr-2">mdi-close-circle</v-icon>
          გაუქმება
        </v-btn>
        <v-btn
            variant="elevated"
            color="primary"
            size="large"
            class="px-10 text-none font-weight-bold"
            @click="save()"
            :loading="saving"
            :disabled="saving"
        >
          <v-icon class="mr-2">mdi-content-save</v-icon>
          შენახვა
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>

  <!-- Snackbar for notifications -->
  <v-snackbar
      v-model="snackbar.visible"
      :color="snackbar.color"
      :timeout="3000"
      location="top"
      rounded="pill"
  >
    <div class="d-flex align-center">
      <v-icon class="mr-3">
        {{ snackbar.color === 'success' ? 'mdi-check-circle' : 'mdi-alert-circle' }}
      </v-icon>
      <span class="font-weight-medium">{{ snackbar.message }}</span>
    </div>
  </v-snackbar>
</template>

<style scoped>
.bg-gradient {
  background: linear-gradient(135deg, rgb(var(--v-theme-primary)) 0%, rgb(var(--v-theme-primary-darken-1)) 100%);
}

:deep(.v-data-table) {
  border-radius: 0 0 8px 8px;
}

:deep(.v-data-table__th) {
  font-weight: 600 !important;
  background-color: rgb(var(--v-theme-grey-lighten-4));
}

:deep(.v-data-table__td) {
  padding: 12px 16px !important;
}

:deep(.v-data-table tr:hover) {
  background-color: rgb(var(--v-theme-grey-lighten-5)) !important;
}
</style>
