import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
  plugins: [vue()],
  build: {
    outDir: "customer/web/js/apps",
    rollupOptions: {
      input: {
        demo: "./src/apps/demo/demo.ts",
        product: "./src/apps/product/product.ts",
      },
      output: {
        entryFileNames: "[name].js",
        chunkFileNames: `[name].js`,
        assetFileNames: `[name].[ext]`,
      },
    },
  },
});
