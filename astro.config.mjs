import { defineConfig } from 'astro/config'

// https://astro.build/config
export default defineConfig({
  devToolbar: {
    enabled: false,
  },
  compressHTML: false,
  scopedStyleStrategy: 'attribute',
  build: {
    inlineStylesheets: `never`,
    format: 'file',
    assets: 'assets',
    assetsPrefix: undefined, // change before upload to stage
  },

  vite: {
    build: {
      minify: false,
      cssCodeSplit: false,
      rollupOptions: {
        output: {
          entryFileNames: 'assets/scripts/bundle.js',
          assetFileNames: 'assets/styles/[name][extname]',
        },
      },
    },
  },
})
