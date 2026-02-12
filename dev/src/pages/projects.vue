<script setup>
import list from "@/components/list.vue";
import Gallery from "@/components/gallery.vue";

import {ref, watch} from "vue";
import http from "@/services/Http.js";
const options = {
  add:true,
  url : "projects"
};
const gallery = {
  id:0,
  show:ref(false),
  open:(item)=>{
    gallery.show.value = true;
    gallery.id = item.id;
  }
};

const fields = [
  {key:"photos", type:"img" , multiple:true },
  {key:"title", type:"text"},
  {key:"subtitle", type:"text"},
  {key:"status", type:"select", options:["მიმდინარე","დასრულებული"]},
  {key:"desc", type:"html"},
  {key:"location", type:"text"},
  {key:"date", type:"date"},
  {key:"active", type:"select",options:[{value:'1',title:"აქტიური"},{value:'0',title:"გამორთული"}]},

]

</script>

<template>
<list :options="options" :fields="fields"  />

</template>

<style scoped>

</style>
