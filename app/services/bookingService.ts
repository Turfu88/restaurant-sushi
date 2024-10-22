import request from '@services/request';
import { BookingForm } from '@models/booking';

export async function postBooking(values: BookingForm) {
    return await request(`/api/bookings/new`, 'POST', values, true).then((res) => {
        if (res.status === 200) {
            return res.json;
        }
        return null;
    })
}

export async function patchBooking(values: BookingForm) {
    return await request(`/api/bookings/${values.id}/edit`, 'PATCH', values, true).then((res) => {
        if (res.status === 200) {
            return res.json;
        }
        return null;
    })
}