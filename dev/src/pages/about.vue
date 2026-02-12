<script setup>
import { ref, computed } from "vue";
import MyEditor from "../components/my-editor.vue";
import http from "@/services/Http.js";


const code = ref(``);
const loaded= ref(false);
function load() {
    http.get("/about").then((res) => {
      code.value = res.code;
        loaded.value = true;
    });
}
load();
function save(){
    http.post("/about", { code: code.value });
}

</script>

<template>
  <v-container  >
     <MyEditor v-if="loaded" v-model="code"/>
  </v-container>
</template>


