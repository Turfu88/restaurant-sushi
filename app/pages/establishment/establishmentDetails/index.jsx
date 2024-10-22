import React from 'react';
import { Button } from '@/components/ui/button';


export function AppView() {
    const establishment = JSON.parse(document.querySelector('.data-js').getAttribute('data-establishment'));
    const editLink = `/establishments/${establishment.id}/edit`;
    const establishmentListLink = '/establishments';

    return (
        <div className="mt-5 px-5">
            <a href={establishmentListLink}>
                <Button>Retour à la liste</Button>
            </a>
            <h1 className="text-2xl font-bold text-center">Fiche établissement</h1>
            <div className="my-10">
                <p className="font-bold">Nom: {establishment.name}</p>
                <p>Status: {establishment.open ? 'Ouvert' : 'Fermé'}</p>
                <p>Adresse: {establishment.address}</p>
                <p>Places disponibles: {establishment.availableSeats}</p>
                <p>Temps limite de réservation: {establishment.timeLimitBeforeCancel}</p>
                <p>Ouverture des réservations (en jours) : {establishment.openingAdvancedBookingDays}</p>
            </div>
            <a href={editLink}>
                <Button>Modifier cet établissement</Button>
            </a>
        </div>
    );
}
