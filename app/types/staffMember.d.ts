export interface StaffMemberForm {
    id: number;
    firstname: string;
    lastname: string;
    role: string;
}

export interface StaffMemberAndUserForm {
    firstname: string;
    lastname: string;
    role: string;
    username: string;
    password: string;
}
