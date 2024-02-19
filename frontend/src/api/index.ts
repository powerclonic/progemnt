import { SignUpData } from "@/types";
import axiosInstance from "./axios";

export const signIn = (identifier: string, password: string, remember: boolean) => {
  return axiosInstance.post("/auth", {identifier, password, remember});
};

export const signUp = (data: SignUpData) => {
  return axiosInstance.post("/user", data);
};

export const userData = () => {
  return axiosInstance.get("/user");
};