// Utilities
import { defineStore } from "pinia";

export const useAppStore = defineStore("app", {
  state: () => ({
    loading: false,
    user_name: localStorage.getItem("user_name") ?? "",
    user_id: Number(localStorage.getItem("user_id")) ?? null,
    access_token: localStorage.getItem("access_token") ?? "",
    _controller: null as AbortController | null,
  }),
  getters: {
    isAuthenticated(): boolean {
      return !!this.access_token;
    },
  },
  actions: {
    setAuthData(data: any) {
      this.unsetAuthData();

      this.user_name = data.name;
      this.user_id = data.user_id;
      this.access_token = data.access_token;
      localStorage.setItem("access_token", data.access_token);
      localStorage.setItem("user_name", data.name);
      localStorage.setItem("user_id", data.user_id);
    },
    unsetAuthData() {
      this.user_name = "";
      this.access_token = "";

      localStorage.removeItem("access_token");
      localStorage.removeItem("user_name");
    },
  },
});
