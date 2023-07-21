import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
  plugins: [vue()],
  build: {
    outDir: "supplier/web/js/apps",
    rollupOptions: {
      input: {
        demo: "./src/apps/demo/demo.ts",
        product: "./src/apps/product/product.ts",
        singleProduct: "./src/apps/singleProduct/singleProduct.ts",
        orders: "./src/apps/orders/orders.ts",
      },
      output: {
        entryFileNames: "[name].js",
        chunkFileNames: `[name].js`,
        assetFileNames: `[name].[ext]`,
      },
    },
  },
});
