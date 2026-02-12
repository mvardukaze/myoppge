<script setup>
import {inject, ref} from "vue";
import {useTheme} from "vuetify";
import {login} from "@/services/User.js";

let     data = ref(
    {user:"",pass:""}
);
const   http = inject("$http");
const visible = ref(false);
let user = inject("$user");
function auth(){
  login(data.value).then(r=>{
    location.reload();
  })
  event.preventDefault();
  user.value = true;
}
const theme = useTheme();
</script>
<template>
    <div class="login_bg">
      <v-card class="pa-5" variant="elevated" >
        <v-btn
          class="position-absolute right-0 top-0"
          style="z-index: 999"
          @click="toggleTheme()"
          :key="theme.global.name"
          variant="text"
          slim
          :icon="theme.global.name.value=='dark'?'mdi-white-balance-sunny':'mdi-moon-waning-crescent'"/>
        <v-img  class="ma-10" src="/src/assets/logo.png" />
        <form @submit="auth()" class="login">
          <v-text-field  v-model="data.user"
                         autocomplete="off"
                         label="მომხმარებელი"
                         prepend-inner-icon="mdi-account" variant="outlined"   />
          <v-text-field
            variant="outlined"
            prepend-inner-icon="mdi-lock"
            v-model="data.pass" label="პაროლი"
            :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
            :type="visible ? 'text' : 'password'"
            @click:append-inner="visible = !visible"
          />
          <v-btn append-icon="mdi-login" type="submit" density="default"  color="primary" >შესვლა</v-btn>
        </form>
      </v-card>
    </div>
</template>
<style>
.login_bg{
  position: fixed;
  inset: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}
.login{
  width: 300px;
  display: flex;
  flex-direction: column;
}

</style>
