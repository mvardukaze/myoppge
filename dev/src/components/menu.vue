<script setup>

</script>

<template>
  <v-list-item v-for="item in $router.options.routes" :to="item.path"  :prepend-icon="item.icon" :title="item.name"  link>{{item.title}}</v-list-item>
</template>

<style scoped>

</style>
