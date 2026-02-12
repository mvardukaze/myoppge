<script setup>

import DateField from "@/components/DateField.vue";
import {ref} from "vue";
const dialog = ref(false);
const model = ref("2022-01-01");

</script>

<template>
  <v-text-field
      variant="outlined"
      v-model="model"
      append-inner-icon="mdi-calendar-blank-outline"
      @click:append-inner="dialog = true"
  >

  </v-text-field>
  <v-dialog v-model="dialog">
    <DateField v-model="model" v-model:dialog="dialog"/>
  </v-dialog>

</template>

<style scoped>

</style>
