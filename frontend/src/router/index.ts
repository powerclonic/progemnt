/**
 * router/index.ts
 *
 * Automatic routes for `./src/pages/*.vue`
 */

// Composables
import { createRouter, createWebHistory } from "vue-router/auto";
import { setupLayouts } from "virtual:generated-layouts";
import { useAppStore } from "@/store/app";
import { useFlashStore } from "@/store/flash";

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  extendRoutes: setupLayouts,
});

router.beforeEach((to, from, next) => {
  if (to.meta.requireAuth && !useAppStore().isAuthenticated) {
    useFlashStore().setMessage(
      "Você deve estar autenticado para acessar esta página",
      "warning",
    );
    next("/signin");
  }

  console.log(to);

  next();
});

export default router;
