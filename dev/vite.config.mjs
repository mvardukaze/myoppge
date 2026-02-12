// Plugins
import Components from 'unplugin-vue-components/vite'
import Vue from '@vitejs/plugin-vue'
import Vuetify, { transformAssetUrls } from 'vite-plugin-vuetify'
import * as fs from 'node:fs'

// Utilities

import { defineConfig } from 'vite'
import { fileURLToPath, URL } from 'node:url'
const ver = parseFloat(fs.readFileSync('version', 'utf8').trim());
const str = (ver + 0.00001).toFixed(5)
function cacheBustPlugin() {
    const append = (url) => (url.includes('?') ? `${url}&${str}` : `${url}?${str}`)
    fs.writeFileSync('version', str)

    return {
        name: 'cache-bust-plugin',

        transformIndexHtml(html) {
            return html
                .replace(/\/app\/index\.js/g, append('/app/index.js'))
                .replace(/\/app\/index\.css/g, append('/app/index.css'))
        },

        generateBundle(_options, bundle) {
            for (const [filename, chunk] of Object.entries(bundle)) {
                if (filename.endsWith('.js') && 'code' in chunk && chunk.code) {
                    chunk.code = chunk.code.replace(
                        /(['"])([^"'()]+\.js)(\1)/g,
                        (_match, q, url, q2) => `${q}${append(url)}${q2}`
                    )
                }
            }
        },
    }
}
export default defineConfig({
  plugins: [
    Vue({
      template: { transformAssetUrls },
    }),
    cacheBustPlugin(),
    Vuetify({
      vuetifyOptions: {
          autoImport: true,
      },
    }),
    Components(),
  ],
  optimizeDeps: {
    exclude: ['vuetify'],
  },
  build: {
    outDir: '../html',
    emptyOutDir: true,
    rollupOptions: {
      output: {
          entryFileNames: `app/index.js`,
          chunkFileNames: `app/pages/[name].js`,
          assetFileNames: (ob) => ob.name === 'index.css' ? `app/index.css` : `app/files/[name].[ext]`,
      },
    },
  },

  define: { 'process.env': {} },
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('src', import.meta.url)),
    },
    extensions: [
      '.js',
      '.json',
      '.jsx',
      '.mjs',
      '.ts',
      '.tsx',
      '.vue',
    ],
  },
    server: {
        proxy: {
            '/api': {
                target: 'https://my.oop.ge/',
                changeOrigin: true,
            },
        },
    },

})
