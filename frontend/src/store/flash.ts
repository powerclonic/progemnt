// Utilities
import { defineStore } from "pinia";

export const useFlashStore = defineStore("flash", {
  state: () => ({
    flash_value: false,
    flash_message: "" as string,
    flash_type: undefined as undefined | "success" | "error" | "warning",
    _flash_persistent: false,
  }),
  actions: {
    setMessage(
      message: string,
      type: typeof this.flash_type,
      persistent: boolean = false,
    ) {
      this.flash_message = message;
      this.flash_type = type;
      this.flash_value = true;
      this._flash_persistent = persistent;
    },
    unsetMessage() {
      this.flash_value = this._flash_persistent;

      this._flash_persistent = false;
    },
  },
});
