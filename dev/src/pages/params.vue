<template>
  <v-container>
    <v-card class="settings-card elevation-4" rounded="lg">
      <!-- Header Section -->
      <v-card-title class="settings-header">
        <div class="d-flex align-center justify-space-between w-100">
          <div class="d-flex align-center">
            <v-icon size="32" color="primary" class="mr-3">mdi-cog</v-icon>
            <div>
              <h2 class="text-h5 font-weight-bold">საიტის პარამეტრები</h2>
              <p class="text-subtitle-2 text-medium-emphasis ma-0">
                მართეთ თქვენი ვებსაიტის ძირითადი ინფორმაცია
              </p>
            </div>
          </div>
          <v-chip
              v-if="editable"
              color="warning"
              variant="flat"
              size="small"
          >
            <v-icon start size="16">mdi-pencil</v-icon>
            რედაქტირება
          </v-chip>
        </div>
      </v-card-title>

      <v-divider></v-divider>

      <!-- Content Section -->
      <v-card-text>
        <v-row>
          <!-- Logo Section -->
          <v-col cols="12">
            <imgField
                style="width: 300px;"
                v-model="data.logo"
                :readonly="!editable"
                class="elevation-2"
            />
          </v-col>

          <v-col cols="12">
            <v-divider class="my-2"></v-divider>
          </v-col>

          <!-- Basic Info -->
          <v-col cols="12" md="6">
            <v-text-field
                v-model="data.name"
                label="საიტის სახელი"
                prepend-inner-icon="mdi-web"
                type="text"
                :required="true"
                :readonly="!editable"
                variant="outlined"
                density="comfortable"
                color="primary"
                :bg-color="editable ? 'white' : 'grey-lighten-4'"
                hide-details="auto"
                class="mb-4"
            >
              <template v-slot:prepend-inner>
                <v-icon color="primary">mdi-web</v-icon>
              </template>
            </v-text-field>
          </v-col>

          <v-col cols="12" md="6">
            <v-text-field
                v-model="data.phone"
                label="ტელეფონის ნომერი"
                type="tel"
                :required="true"
                :readonly="!editable"
                variant="outlined"
                density="comfortable"
                color="primary"
                :bg-color="editable ? 'white' : 'grey-lighten-4'"
                hide-details="auto"
                class="mb-4"
            >
              <template v-slot:prepend-inner>
                <v-icon color="primary">mdi-phone</v-icon>
              </template>
            </v-text-field>
          </v-col>

          <v-col cols="12" md="6">
            <v-text-field
                v-model="data.email"
                label="ელ-ფოსტა"
                type="email"
                :required="true"
                :readonly="!editable"
                variant="outlined"
                density="comfortable"
                color="primary"
                :bg-color="editable ? 'white' : 'grey-lighten-4'"
                hide-details="auto"
                class="mb-4"
            >
              <template v-slot:prepend-inner>
                <v-icon color="primary">mdi-email</v-icon>
              </template>
            </v-text-field>
          </v-col>

          <v-col cols="12" md="6">
            <v-text-field
                v-model="data.address"
                label="მისამართი"
                type="text"
                :required="true"
                :readonly="!editable"
                variant="outlined"
                density="comfortable"
                color="primary"
                :bg-color="editable ? 'white' : 'grey-lighten-4'"
                hide-details="auto"
                class="mb-4"
            >
              <template v-slot:prepend-inner>
                <v-icon color="primary">mdi-map-marker</v-icon>
              </template>
            </v-text-field>
          </v-col>

          <!-- Divider -->
          <v-col cols="12">
            <v-divider class="my-2"></v-divider>
            <h3 class="text-h6 mt-4 mb-2">
              <v-icon color="primary" class="mr-2">mdi-palette</v-icon>
              დიზაინის პარამეტრები
            </h3>
          </v-col>

          <!-- Design Settings -->
          <!-- Design Settings -->
          <v-col cols="12" md="6">
            <v-color-input
                v-model="data.backgroundColor"
                label="ფონის ფერი"
                :readonly="!editable"
                variant="outlined"
                density="comfortable"
                :bg-color="editable ? 'white' : 'grey-lighten-4'"

                hide-pip
                class="mb-4"
            >
              <template v-slot:prepend-inner>
                <v-icon :color="data.backgroundColor">mdi-format-color-fill</v-icon>
              </template>
            </v-color-input>
          </v-col>

          <v-col cols="12" md="6">
            <v-color-input
                v-model="data.textColor"
                label="ფონტის ფერი"
                :readonly="!editable"
                variant="outlined"
                density="comfortable"
                :bg-color="editable ? 'white' : 'grey-lighten-4'"

                hide-pip
                class="mb-4"
            >
              <template v-slot:prepend-inner>
                <v-icon :color="data.textColor">mdi-format-color-text</v-icon>
              </template>
            </v-color-input>
          </v-col>

          <v-col cols="12" md="6">
            <v-color-input
                v-model="data.headerColor"
                label="ჰედერის ფერი"
                :readonly="!editable"
                variant="outlined"
                density="comfortable"
                :bg-color="editable ? 'white' : 'grey-lighten-4'"

                hide-pip
                class="mb-4"
            >
              <template v-slot:prepend-inner>
                <v-icon :color="data.headerColor">mdi-page-layout-header</v-icon>
              </template>
            </v-color-input>
          </v-col>

          <v-col cols="12" md="6">
            <v-color-input
                v-model="data.footerColor"
                label="ფუტერის ფერი"
                :readonly="!editable"
                variant="outlined"
                density="comfortable"
                :bg-color="editable ? 'white' : 'grey-lighten-4'"

                hide-pip
                class="mb-4"
            >
              <template v-slot:prepend-inner>
                <v-icon :color="data.footerColor">mdi-page-layout-footer</v-icon>
              </template>
            </v-color-input>
          </v-col>

          <v-col cols="12" md="6">
            <v-color-input
                v-model="data.primaryColor"
                label="ძირითადი ფერი"
                :readonly="!editable"
                variant="outlined"
                density="comfortable"
                :bg-color="editable ? 'white' : 'grey-lighten-4'"

                hide-pip
                class="mb-4"
            >
              <template v-slot:prepend-inner>
                <v-icon :color="data.primaryColor">mdi-palette-swatch</v-icon>
              </template>
            </v-color-input>
          </v-col>

          <v-col cols="12" md="6">
            <v-color-input
                v-model="data.buttonColor"
                label="ღილაკის ფერი"
                :readonly="!editable"
                variant="outlined"
                density="comfortable"
                :bg-color="editable ? 'white' : 'grey-lighten-4'"

                hide-pip
                class="mb-4"
            >
              <template v-slot:prepend-inner>
                <v-icon :color="data.buttonColor">mdi-gesture-tap-button</v-icon>
              </template>
            </v-color-input>
          </v-col>

          <!-- Divider -->
          <v-col cols="12">
            <v-divider class="my-2"></v-divider>
            <h3 class="text-h6 mt-4 mb-2">
              <v-icon color="primary" class="mr-2">mdi-share-variant</v-icon>
              სოციალური ქსელები
            </h3>
          </v-col>

          <!-- Social Media -->
          <v-col cols="12" md="6">
            <v-text-field
                v-model="data.fb"
                label="Facebook ლინკი"
                type="url"
                :required="true"
                :readonly="!editable"
                variant="outlined"
                density="comfortable"
                color="primary"
                :bg-color="editable ? 'white' : 'grey-lighten-4'"
                hide-details="auto"
                class="mb-4"
                placeholder="https://facebook.com/yourpage"
            >
              <template v-slot:prepend-inner>
                <v-icon color="#1877F2">mdi-facebook</v-icon>
              </template>
            </v-text-field>
          </v-col>

          <v-col cols="12" md="6">
            <v-text-field
                v-model="data.instagram"
                label="Instagram ლინკი"
                type="url"
                :required="true"
                :readonly="!editable"
                variant="outlined"
                density="comfortable"
                color="primary"
                :bg-color="editable ? 'white' : 'grey-lighten-4'"
                hide-details="auto"
                class="mb-4"
                placeholder="https://instagram.com/yourprofile"
            >
              <template v-slot:prepend-inner>
                <v-icon color="#E4405F">mdi-instagram</v-icon>
              </template>
            </v-text-field>
          </v-col>
        </v-row>
      </v-card-text>

      <v-divider></v-divider>

      <!-- Action Buttons -->
      <v-card-actions class="pa-6 bg-grey-lighten-5">
        <v-spacer></v-spacer>
        <template v-if="editable">
          <v-btn
              @click="cancel"
              variant="outlined"
              color="grey-darken-1"
              size="large"
              class="px-6"
              :disabled="loading"
          >
            <v-icon start>mdi-close</v-icon>
            გაუქმება
          </v-btn>
          <v-btn
              @click="save"
              variant="flat"
              color="primary"
              size="large"
              class="px-6 ml-3"
              :loading="loading"
          >
            <v-icon start>mdi-content-save</v-icon>
            შენახვა
          </v-btn>
        </template>
        <template v-else>
          <v-btn
              @click="editable = true"
              variant="flat"
              color="primary"
              size="large"
              class="px-6"
          >
            <v-icon start>mdi-pencil</v-icon>
            რედაქტირება
          </v-btn>
        </template>
      </v-card-actions>
    </v-card>

    <!-- Success Snackbar -->
    <v-snackbar
        v-model="snackbar"
        :color="snackbarColor"
        timeout="3000"
        location="top"
    >
      <div class="d-flex align-center">
        <v-icon class="mr-2">{{ snackbarIcon }}</v-icon>
        {{ snackbarText }}
      </div>
    </v-snackbar>
  </v-container>
</template>

<script setup>
import { ref, toRaw } from "vue";
import { VColorInput } from 'vuetify/labs/VColorInput'

import http from "@/services/Http.js";
import { params } from "@/services/User.js";

const editable = ref(false);
const loading = ref(false);
const data = ref(params);
const originalData = ref(null);

// Snackbar
const snackbar = ref(false);
const snackbarText = ref("");
const snackbarColor = ref("success");
const snackbarIcon = ref("mdi-check-circle");

function cancel() {
  if (originalData.value) {
    data.value = structuredClone(originalData.value);
  }
  editable.value = false;
}

async function save() {
  loading.value = true;
  try {
    let d = structuredClone(toRaw(data.value));
    await http.post("main", d);

    snackbarText.value = "ცვლილებები წარმატებით შეინახა!";
    snackbarColor.value = "success";
    snackbarIcon.value = "mdi-check-circle";
    snackbar.value = true;

    editable.value = false;

    setTimeout(() => {
      location.reload();
    }, 1500);
  } catch (error) {
    snackbarText.value = "შეცდომა! გთხოვთ სცადოთ თავიდან.";
    snackbarColor.value = "error";
    snackbarIcon.value = "mdi-alert-circle";
    snackbar.value = true;
  } finally {
    loading.value = false;
  }
}

function load(){
  http.get()
}
</script>

<style scoped>
.settings-card {
  background: linear-gradient(to bottom, #ffffff 0%, #fafafa 100%);
}

.settings-header {
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.logo-section {
  background: #f8f9fa;
  padding: 24px;
  border-radius: 12px;
  border: 2px dashed #e0e0e0;
}

.v-text-field {
  transition: all 0.3s ease;
}

.v-text-field:hover {
  transform: translateY(-1px);
}

.v-card {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.v-text-field--readonly :deep(.v-icon) {
  opacity: 0.6;
}
</style>
