import request from '@services/request';
import { StaffMemberForm, StaffMemberAndUserForm } from '@models/staffMember';

export async function postStaffMember(values: StaffMemberAndUserForm) {
    return await request(`/api/staff-members/new`, 'POST', values, true).then((res) => {
        if (res.status === 200) {
            return res.json;
        }
        return null;
    })
}

export async function patchStaffMember(values: StaffMemberForm) {
    return await request(`/api/staff-members/${values.id}/edit`, 'PATCH', values, true).then((res) => {
        if (res.status === 200) {
            return res.json;
        }
        return null;
    })
}

export async function addStaffMemberEstablishment(staffMemberId: number, establishmentId: number) {
    const values = { action: 'add', establishmentId };

    return await request(`/api/staff-members/${staffMemberId}/establishment-toggle`, 'POST', values, true).then((res) => {
        if (res.status === 200) {
            return res.json;
        }
        return null;
    })
}

export async function removeStaffMemberEstablishment(staffMemberId: number, establishmentId: number) {
    const values = { action: 'remove', establishmentId };

    return await request(`/api/staff-members/${staffMemberId}/establishment-toggle`, 'POST', values, true).then((res) => {
        if (res.status === 200) {
            return res.json;
        }
        return null;
    })
}

