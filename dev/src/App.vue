<template>
  <v-app>

      <template v-if="loaded">
        <Login v-if="!user" />
        <Layout v-else />
      </template>
      <loading v-else progress-text="მიმდინარეობს ცატვირთვა" />

  </v-app>
</template>

<script setup>
import Layout from "@/view/Layout.vue";
import Login from "@/view/Login.vue";
import Loading from "@/view/Loading.vue";
import {init,user,loaded} from "@/services/User.js";
init();
</script>
