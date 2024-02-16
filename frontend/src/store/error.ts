// Utilities
import { defineStore } from 'pinia'

export const useErrorStore = defineStore('error', {
  state: () => ({
    error_message: '',
    timeout: undefined as NodeJS.Timeout|undefined
  }),
  actions: {
    setError(message: string) {
        this.error_message = message;

        clearTimeout(this.timeout);

        this.timeout = setTimeout(() => this.error_message = '', 10 * 1000);
    }
  }
})
