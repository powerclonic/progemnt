import axiosInstance from ".";

export const signIn = (identifier: string, password: string, remember: boolean) => {
    return axiosInstance.post('/auth', {identifier, password, remember});
};