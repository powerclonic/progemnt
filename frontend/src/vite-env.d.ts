/// <reference types="vite/client" />

import { useAppStore } from "./store/app";

declare module "*.vue" {
  import type { DefineComponent } from "vue";
  const component: DefineComponent<{}, {}, any>;
  export default component;
  interface ComponentCustomProperties {
    $app: typeof useAppStore;
  }
}

declare module "@vue/runtime-core" {
  interface ComponentCustomProperties {
    $app: ReturnType<typeof useAppStore>;
  }
}
