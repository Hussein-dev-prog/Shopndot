import { createApp } from "vue";

import Vue3Toasity, { type ToastContainerOptions } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

declare var window: any;

export function newApp(name, App) {
  window.vueApps = window.vueApps || {};
  window.vueApps[name] = (id: string, params: any) => {
    // const app = createApp(App, params);
    // app.use(Vue3Toasity, {
    //   autoClose: 3000,
    //   // ...
    // } as ToastContainerOptions);
    // app.mount(`#${id}`);
    createApp(App, params)
      .use(Vue3Toasity, {
        autoClose: 3000,
        // ...
      } as ToastContainerOptions)
      .mount(`#${id}`);
    // createApp(App, params).mount(`#${id}`);
  };
}
