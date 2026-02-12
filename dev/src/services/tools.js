
import {reactive, ref} from "vue";

const $menu = {
  // 1. Parse the value correctly (null/undefined defaults to false)
  open: ref(localStorage.getItem("menu.open") === "true"),

  toggle() {
    // 2. Update the reactive ref
    this.open.value = !this.open.value;

    // 3. Sync back to localStorage
    localStorage.setItem("menu.open", this.open.value.toString());
  }
};

export { $menu };
