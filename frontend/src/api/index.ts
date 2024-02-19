import { SignUpData, UpdateUserData } from "@/types";
import ax from "./axios";

export const signIn = (identifier: string, password: string, remember: boolean) => {
  return ax.post("/auth", {identifier, password, remember});
};

export const signOut = () => {
  return ax.delete("/auth");
};

export const signUp = (data: SignUpData) => {
  return ax.post("/user", data);
};

export const userData = () => {
  return ax.get("/user");
};

export const userDashboardData = () => {
  return ax.get("/user/dashboard");
};

export const userDestroy = () => {
  return ax.delete("/user");
};

export const userUpdate = (data: UpdateUserData) => {
  return ax.put("/user", data);
};

