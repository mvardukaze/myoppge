import vuetify from './vuetify'
import {createRouter, createWebHistory} from "vue-router";
import main from "@/pages/main.vue";
import projects from "@/pages/projects.vue";
import services from "@/pages/services.vue";
import about from "@/pages/about.vue";
import faq from "@/pages/faq.vue";
import params from "@/pages/params.vue";
const routes = [
    {path: '/',  icon: "mdi-home",   component: main, title: "მთავარი გვერდი"},
    {path: '/params',  icon: "mdi-tune",   component: params, title: "პარამეტრები"},
    {path: '/projects',  icon: "mdi-briefcase-variant",   component: projects, title: "პროექტები"},
    {path: '/services',  icon: "mdi-hammer-wrench",   component: services, title: "სერვისები"},
    {path: '/faq',  icon: "mdi-help-circle-outline",   component: faq, title: "შეკითხვები"},
    {path: '/about',  icon: "mdi-information-outline",   component: about, title: "ჩვენს შესახებ"},
];
const router = createRouter({ history: createWebHistory(),routes});
export function registerPlugins (app) {
  app.config.globalProperties.toggleTheme = () => {
    if(vuetify.theme.global.name.value=="dark"){
      vuetify.theme.global.name.value = "light";
    }else{
      vuetify.theme.global.name.value = "dark";
    }
  }
  app.use(router);
  app.use(vuetify)
}
