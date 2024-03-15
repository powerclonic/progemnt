/**
 * main.ts
 *
 * Bootstraps Vuetify and other plugins then mounts the App`
 */

// Plugins
import { registerPlugins } from "@/plugins";

// Components
import App from "./App.vue";

// Composables
import { createApp } from "vue";
import { useAppStore } from "./store/app";

const app = createApp(App);

registerPlugins(app);

app.config.globalProperties.$app = useAppStore();

app.mount("#app");
