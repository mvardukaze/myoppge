<script setup>
import list from "@/components/list.vue";
import Gallery from "@/components/gallery.vue";
import {ref} from "vue";
const options = {
  add:true,
  url : "faq"
};
const fields = [
  {key:"title", type:"text"},
  {key:"detail", type:"html"},
  {key:"active", type:"select",options:[{value:'1',title:"აქტიური"},{value:'0',title:"გამორთული"}]},

]

</script>

<template>
  <list :options="options" :fields="fields"   />
</template>

<style scoped>

</style>
