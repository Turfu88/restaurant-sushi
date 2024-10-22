import request from '@services/request';
import { EstablishmentForm } from '@models/establishment';

export async function postEstablishment(values: EstablishmentForm) {
    return await request(`/api/establishments/new`, 'POST', values, true).then((res) => {
        if (res.status === 200) {
            return res.json;
        }
        return null;
    })
}

export async function patchEstablishment(values: EstablishmentForm) {
    return await request(`/api/establishments/${values.id}/edit`, 'PATCH', values, true).then((res) => {
        if (res.status === 200) {
            return res.json;
        }
        return null;
    })
}
