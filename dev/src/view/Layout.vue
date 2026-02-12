<script setup>
import Header from "@/view/Header.vue";
import Nav    from "@/view/Nav.vue";
import {RouterView} from 'vue-router';


</script>
<template>
  <v-app>
    <Nav />
    <Header />
    <v-main>
      <RouterView class="router"  />
    </v-main>
  </v-app>
</template>
<style scoped>

</style>
