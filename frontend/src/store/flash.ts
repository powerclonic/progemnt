// Utilities
import { defineStore } from "pinia";

export const useFlashStore = defineStore("flash", {
  state: () => ({
    flash_value: false,
    flash_message: "" as string,
    flash_type: null as null | "success" | "error" | "warning",
    timeout: undefined as NodeJS.Timeout | undefined
  }),
  actions: {
    setMessage(message: string, type: typeof this.flash_type) {
      this.flash_message = message;
      this.flash_type = type;
      this.flash_value = Boolean(message);
        
      clearTimeout(this.timeout);

      this.timeout = setTimeout(() => { this.flash_message = ""; this.flash_type = null; this.flash_value = false; }, 10 * 1000);
    }
  }
});
