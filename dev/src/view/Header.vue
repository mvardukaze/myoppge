<script setup>
import {useTheme} from "vuetify";
import {$menu} from "@/services/tools.js";
import {logout} from "@/services/User.js";

const theme = useTheme();
const toggleTheme = () => {
  if(theme.global.name.value=="dark"){
    theme.global.name.value="light";
  }else{
    theme.global.name.value="dark"
  }
  return theme.global.name.value;
};



</script>

<template>
  <v-app-bar  color="primary" :elevation="1" >

    <v-app-bar-nav-icon @click="$menu.toggle()" />



    <v-spacer></v-spacer>

    <v-app-bar-title>

    </v-app-bar-title>

    <v-spacer></v-spacer>
    <v-btn icon="mdi-sync"  link/>
    <v-btn @click="toggleTheme()" :key="theme.global.name" :icon="theme.global.name.value!='dark'?'mdi-white-balance-sunny':'mdi-weather-night'"/>
    <v-btn icon>
      <v-badge color="error" content="2">
        <v-icon>mdi-bell</v-icon>
      </v-badge>
      <v-menu activator="parent">
        <v-list>
          <v-list-item prepend-icon="mdi-account" to="/notification/1"  title="შეტყობინება1"  subtitle="შეტყობინების ტექსტი" link/>

          <v-list-item prepend-icon="mdi-account" to="/notification/2"  title="შეტყობინება2"  subtitle="შეტყობინების ტექსტი" link/>
          <v-list-item prepend-icon="mdi-account" to="/notification/3"  title="შეტყობინება3"  subtitle="შეტყობინების ტექსტი" link/>
          <v-divider thickness="4"/>
          <v-list-item  prepend-icon="mdi-bell" to="/notification" title="შეტყობინებები" link/>
        </v-list>
      </v-menu>
    </v-btn>
    <v-btn icon>
      <v-badge color="success" dot> <v-icon>mdi-account</v-icon> </v-badge>
      <v-menu activator="parent">
        <v-list>
          <v-list-item prepend-icon="mdi-account" subtitle="ადმინი"  title="სახელი გვარი" />
          <v-divider thickness="4"/>
          <v-list-item to="/profile" prepend-icon="mdi-account-edit" title="პროფილი" link/>
          <v-list-item to="/setting" prepend-icon="mdi-cog" title="პარამეტრები" link/>
          <v-divider thickness="4"/>
          <v-list-item  @click="logout()" prepend-icon="mdi-logout" title="გასვლა" link/>
        </v-list>
      </v-menu>
    </v-btn>
  </v-app-bar>
</template>

<style scoped>

</style>
