import { useErrorStore } from '@/store/error';
import { useAppStore } from '@/store/app';

import axios from 'axios';

const axiosInstance = axios.create({
    baseURL: import.meta.env.VITE_BASE_API_URL,
    headers: {
        'Authorization': 'Bearer ' + localStorage.getItem("access_token")
    }
});

axiosInstance.interceptors.request.use((request) => {
    useAppStore().loading = true;
    
    return request;
})

axiosInstance.interceptors.response.use(
    (response) => {
        useAppStore().loading = false;

        return response;
    }, 
    (error) => {
        if (!error.response.data) return error;
        useErrorStore().setError(error.response.data);

        useAppStore().loading = false;

        return Promise.reject(error);
});

export default axiosInstance;