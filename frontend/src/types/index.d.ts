export type SignUpData = {
    name: string,
    username: string,
    email: string,
    password: string
}

export type UpdateUserData = {
    email?: string,
    password?: string,
    current_password?: string
}