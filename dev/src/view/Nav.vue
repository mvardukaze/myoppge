



<template>

  <template v-if="$vuetify.display.mobile" >
    <v-navigation-drawer
        color="primary"
        v-model="$menu.open.value"
        temporary>
      <v-img  width="150" cover  src="/src/assets/logo.png" />
      <v-list density="compact">
        <Menu/>
      </v-list>
    </v-navigation-drawer>
  </template>
  <template v-else>
    <v-navigation-drawer
        color="primary"
        :rail="$menu.open.value"
        permanent>
      <v-img   src="/src/assets/logo.png" />
      <v-list density="compact">

        <Menu/>
      </v-list>
    </v-navigation-drawer>
  </template>

</template>

<style scoped>
/*
 :rail=""
permanent
*/
</style>
<script setup>
import Menu from "@/components/menu.vue";
import {$menu} from "@/services/tools.js";
</script>
