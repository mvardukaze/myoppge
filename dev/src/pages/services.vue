<script setup>
import list from "@/components/list.vue";
import Gallery from "@/components/gallery.vue";
import {ref} from "vue";
const options = {
  add:true,
  url : "services"
};
const fields = [
  {key:"icon", type:"img" },
  {key:"title", type:"text"},
  {key:"short", type:"html"},
  {key:"detail", type:"html"},

]
const gallery = {
  id:0,
  show:ref(false),
  open:(item)=>{
    gallery.show.value = true;
    gallery.id = item.id;
  }
};
</script>

<template>
  <list :options="options" :fields="fields" :open="gallery.open"  />
</template>

<style scoped>

</style>
