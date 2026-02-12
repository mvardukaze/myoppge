<template>
  <v-container fluid>
    <v-row>
      <v-col cols="12" md="6">
        <v-card variant="outlined" height="500px">
          <code-mirror
              v-model="model"
              :lang="html()"
              :extensions="extensions"
              height="500px"
              basic
          />
        </v-card>
      </v-col>

      <v-col cols="12" md="6">
        <v-card variant="outlined" height="500px" class="overflow-y-auto pa-4">
          <Preview :html="model" />
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { computed } from 'vue'
import CodeMirror from 'vue-codemirror6'
import { html } from '@codemirror/lang-html'
import { oneDark } from '@codemirror/theme-one-dark'
import { useTheme } from 'vuetify'
import Preview from "@/components/Preview.vue"

const model = defineModel()
const theme = useTheme()

const extensions = computed(() => {
  return theme.global.current.value.dark ? [oneDark] : []
})
</script>

<style scoped>
/* აუცილებელია, რომ CodeMirror-მა შეავსოს მშობელი კონტეინერის სიმაღლე */
:deep(.cm-editor) {
  height: 100%;
}

:deep(.cm-scroller) {
  overflow: auto !important;
}
</style>
