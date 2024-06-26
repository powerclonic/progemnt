import { useFlashStore } from "@/store/flash";
import { useAppStore } from "@/store/app";

import axios, { AxiosError } from "axios";
import router from "@/router";

const axiosInstance = axios.create({
  baseURL: import.meta.env.VITE_BASE_API_URL,
});

axiosInstance.interceptors.request.use(
  (request) => {
    try {
      const store = useAppStore();

      if (request.method != "post" && request.method != "get") {
        request.data = { ...request.data, _method: request.method };
        request.method = "post";
      }

      if (store.isAuthenticated)
        request.headers.setAuthorization("Bearer " + store.access_token);

      const controller = new AbortController();

      request.signal = controller.signal;

      if (store._controller) store._controller.abort();
      store.loading = true;
      store._controller = controller;

      useFlashStore().unsetMessage();
    } catch (e) {
      console.error("e", e);
    }

    return request;
  },
  (error) => {
    if (!error.response.data) return error;
    useFlashStore().setMessage(error.response.data, "error");

    useAppStore().loading = false;

    return Promise.reject(error);
  },
);

axiosInstance.interceptors.response.use(
  (response) => {
    useAppStore().loading = false;

    return response;
  },
  (error: AxiosError) => {
    if (error.message === "canceled") return;

    useAppStore().loading = false;

    if (!error.response) {
      useFlashStore().setMessage("Um erro inesperado aconteceu", "error");
      return Promise.reject(error);
    }

    const data: any = error.response.data;

    switch (error.request.status) {
      case 401: {
        if (data && data.message === "Unauthenticated.") {
          useAppStore().unsetAuthData();
          useFlashStore().setMessage(
            "Sua sessão expirou, entre novamente.",
            "warning",
          );
          router.push("/signin");
          break;
        }

        useFlashStore().setMessage(data, "error");
        break;
      }
      case 403: {
        router.push("/dashboard");
        useFlashStore().setMessage(
          "Seu nível de permissão neste projeto não permite esta ação.",
          "warning",
          true,
        );
        break;
      }
      case 422: {
        useFlashStore().setMessage(data.message, "error");
        break;
      }
      default: {
        useFlashStore().setMessage(data, "error");
        break;
      }
    }

    return Promise.reject(error);
  },
);

export default axiosInstance;
