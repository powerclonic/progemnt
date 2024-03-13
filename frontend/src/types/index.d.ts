export type SignUpData = {
  name: string;
  username: string;
  email: string;
  password: string;
};

export type UpdateUserData = {
  email?: string;
  password?: string;
  current_password?: string;
};

export type Project = {
  id: number;
  title: string;
  description: string;
  deadline: string;
  visibility: number;
  users: Array<ProjectUser>;
  tasks: Array<any>;
  created_at: string;
  updated_at: string;
};

export type ProjectUser = {
  id: number;
  name: string;
  permission: number;
};

export type BareTask = {
  title: string;
  description: null | string;
  deadline: null | string;
  responsible: null | number;
};

export type Task = BareTask & {
  id: number;
  status: 1 | 2 | 3 | 4;
};
