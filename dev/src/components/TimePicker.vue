<script setup>

import TimeField from "@/components/TimeField.vue";
import {ref} from "vue";
const dialog = ref(false);
const model = ref("00:00");

</script>

<template>
  <v-text-field
      variant="outlined"
      v-model="model"
      append-inner-icon="mdi-clock-time-four-outline"
      @click:append-inner="dialog = true"
  >

  </v-text-field>
  <v-dialog v-model="dialog">
    <TimeField v-model="model" v-model:dialog="dialog"/>
  </v-dialog>

</template>

<style scoped>

</style>
