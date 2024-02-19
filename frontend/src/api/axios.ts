import { useFlashStore } from "@/store/flash";
import { useAppStore } from "@/store/app";

import axios from "axios";

const axiosInstance = axios.create({
  baseURL: import.meta.env.VITE_BASE_API_URL,
});

axiosInstance.interceptors.request.use(
  (request) => {
    useAppStore().loading = true;

    if (useAppStore().isAuthenticated) request.headers.setAuthorization("Bearer " + useAppStore().access_token);

    return request;
  },
  (error) => {
    if (!error.response.data) return error;
    useFlashStore().setMessage(error.response.data, "error");

    useAppStore().loading = false;

    return Promise.reject(error);
  });

axiosInstance.interceptors.response.use(
  (response) => {
    useAppStore().loading = false;

    return response;
  },
  (error) => {
    if (!error.response.data) return error;
    useFlashStore().setMessage(error.response.data, "error");

    useAppStore().loading = false;

    return Promise.reject(error);
  });

export default axiosInstance;