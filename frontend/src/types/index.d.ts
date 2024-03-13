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
  id: int;
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
  id: int;
  name: string;
  permission: int;
};
