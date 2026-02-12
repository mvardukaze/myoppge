// services/user.js
import { ref } from "vue";
import http from "@/services/Http";
const loaded = ref(false);


let user = false;
let params = {};

async function code(code) {
  return await http.post('auth', {code:code});
}
async function login(data){
  return await http.post('auth', data);
}
async function  logout(){
  document.cookie.split(";").forEach(function(c) { document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/"); });
  location.replace("/");
}
async function load(){
  return await http.get('init')
}
function init() {
  loaded.value = false;
  load().then(res=>{
    if(res.status==='ok'){
      user=res.user;
        params=res.params;
    }

  }).finally(res=>{
    loaded.value = true;
  });
}export { init, login, logout, load , user, code, loaded ,params};
