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

export const userProjects = () => {
  return ax.get("/projects");
};

export const showProject = (project: number) => {
  return ax.get(`/projects/${project}`);
};

export const createProject = (data: any) => {
  return ax.post("/projects", data);
};

export const updateProject = (project: number, data: any) => {
  return ax.put(`/projects/${project}`, data);
};

export const deleteProject = (project: number) => {
  return ax.delete(`/projects/${project}`);
};

export const createTask = (project: number, data: any) => {
  return ax.post("/tasks", { project_id: project, ...data });
};

export const updateTask = (task: number, data: any) => {
  return ax.put(`/tasks/${task}`, data );
};

export const deleteTask = (task: number) => {
  return ax.delete(`/tasks/${task}`);
};

export const createMember = (project: number, member: string) => {
  return ax.post(`/projects/${project}/members`, { member });
};
  
export const updateMember = (project: number, member: string, permission: number) => {
  return ax.put(`/projects/${project}/members`, { member, permission } );
};
  
export const deleteMember = (project: number, member: string) => {
  return ax.delete(`/projects/${project}/members`, { data: { member }});
};