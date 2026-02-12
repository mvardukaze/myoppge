<template>
  <iframe
      class="preview-frame"
      :sandbox="sandbox"
      :referrerpolicy="referrerPolicy"
      :style="{ height: fixedHeight + 'px' }"
      :srcdoc="srcdoc"
  />
</template>

<script setup>
import {computed} from "vue";

const props = defineProps({
  html: {type: String, default: ""},
  cssUrl: {type: String, default: ""},
  cssUrls: {type: Array, default: () => []},
  fixedHeight: {type: Number, default: 500},
  sandbox: { type: String, default: "allow-forms allow-popups allow-modals allow-scripts" },
  referrerPolicy: {type: String, default: "no-referrer"},
  baseCss: {type: String, default: "html,body{margin:0;padding:0} body{font-family:Arial,sans-serif;}"},
});

function escapeForSrcdoc(s) {

  return (s ?? "").toString();
}

const urls = computed(() => {
  const list = [];
  if (props.cssUrl) list.push(props.cssUrl);
  for (const u of props.cssUrls || []) if (u) list.push(u);
  return list;
});
const tailwind = `<script src="https://cdn.tailwindcss.com"></s\cript>`;
const srcdoc = computed(() => {
  const links = urls.value
      .map((u) => `<link rel="stylesheet" href="${u}">`)
      .join("\n");

  return `<!doctype html>
<html>
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
   <link rel="stylesheet" href="//cdn.web-fonts.ge/fonts/bpg-banner-supersquare-caps/css/bpg-banner-supersquare-caps.min.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  ${tailwind}
  ${links}
  <style>${props.baseCss || ""}</style>
</head>
<body>
${escapeForSrcdoc(props.html)}
</body>
</html>`;
});
</script>

<style scoped>
.preview-frame {
  width: 100%;
  border: 1px solid rgba(0, 0, 0, .12);
  border-radius: 12px;
  background: #fff;
}
</style>
