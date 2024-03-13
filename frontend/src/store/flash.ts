// Utilities
import { defineStore } from "pinia";

export const useFlashStore = defineStore("flash", {
  state: () => ({
    flash_value: false,
    flash_message: "" as string,
    flash_type: undefined as undefined | "success" | "error" | "warning",
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
});
