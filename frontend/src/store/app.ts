// Utilities
import { defineStore } from "pinia";

export const useAppStore = defineStore("app", {
  state: () => ({
    loading: false,
    user_name: localStorage.getItem("user_name") ?? "",
    access_token: localStorage.getItem("access_token") ?? ""
  }),
  getters: {
    isAuthenticated: () => !!localStorage.getItem("access_token")
  },
  actions: {
    setAuthData(data: any) {
      this.unsetAuthData();
      
      this.user_name = data.name;
      this.access_token = data.access_token;
      localStorage.setItem("access_token", data.access_token);
      localStorage.setItem("user_name", data.name);
    },
    unsetAuthData() {
      this.user_name = "";
      this.access_token = "";

      localStorage.removeItem("access_token");
      localStorage.removeItem("user_name");
    }
  }
});
