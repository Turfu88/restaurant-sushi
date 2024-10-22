import React from 'react';
import { Button } from '@/components/ui/button';
import { dateLocaleFormat, timeLocaleFormat } from '@/lib/dateFormat';
export function AppView() {
    const booking = JSON.parse(document.querySelector('.data-js').getAttribute('data-booking'));
    const editLink = `/bookings/${booking.id}/edit`;
    const bookingListLink = '/bookings';

    return (
        <div className="mt-5 px-5">
            <a href={bookingListLink}>
                <Button>Retour aux réservations</Button>
            </a>
            <h1 className="text-2xl font-bold text-center">Détails réservation</h1>
            <div className="my-10">
                <p className="font-bold">Nom: {booking.name}</p>
                <p>Nombre de personnes: {booking.peopleNumber}</p>
                <p>Contact: {booking.phoneNumber ?? 'Non renseigné'}</p>
                <p>Service: {booking.mealTime.service} pour le {dateLocaleFormat(booking.mealTime.date.timestamp)}</p>
                <p>Restaurant: {booking.establishment.name}</p>
                <p>Réservé le: {dateLocaleFormat(booking.createdAt.timestamp)} à {timeLocaleFormat(booking.createdAt.timestamp)}</p>
            </div>
            <a href={editLink}>
                <Button>Modifier ce booking</Button>
            </a>
        </div>
    );
}
