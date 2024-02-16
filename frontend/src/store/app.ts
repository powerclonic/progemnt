// Utilities
import { defineStore } from 'pinia'

export const useAppStore = defineStore('app', {
  state: () => ({
    loading: false,
    user_name: localStorage.getItem('user_name') ?? '',
  }),
  getters: {
    isAuthenticated: () => !!localStorage.getItem('access_token')
  },
  actions: {
    setAuthData(data: any) {
        this.user_name = data.name;

        localStorage.setItem('access_token', data.access_token);
        localStorage.setItem('user_name', data.name);
    },
    unsetAuthData() {
        this.user_name = '';

        localStorage.removeItem('access_token');
        localStorage.removeItem('user_name');
    }
  }
})
