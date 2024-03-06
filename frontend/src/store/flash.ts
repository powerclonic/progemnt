// Utilities
import { defineStore } from "pinia";

export const useFlashStore = defineStore("flash", {
  state: () => ({
    flash_value: false,
    flash_message: "" as string,
    flash_type: null as null | "success" | "error" | "warning",
    timeout: undefined as NodeJS.Timeout | undefined,
  }),
  actions: {
    setMessage(message: string, type: typeof this.flash_type) {
      this.flash_message = message;
      this.flash_type = type;
      this.flash_value = true;
    },
    unsetMesage() {
      this.flash_value = false;
    },
  },
  getters: {
    flash_icon() {
      switch (this.flash_type) {
        case "error":
          return "mdi-alert-circle";
        case "warning":
          return "mdi-alert";
        case "success":
          return "mdi-check-circle";
        default:
          return "mdi-alert-circle";
      }
    },
  },
});
