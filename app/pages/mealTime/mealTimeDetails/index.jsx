import React from 'react';
import { Button } from '@/components/ui/button';
import { dateLocaleFormat } from '@/lib/dateFormat';

export function AppView() {
    const mealTime = JSON.parse(document.querySelector('.data-js').getAttribute('data-meal-time'));
    const editLink = `/meal-times/${mealTime.id}/edit`;
    const mealTimeListLink = '/meal-times';

    return (
        <div className="mt-5 px-5">
            <a href={mealTimeListLink}>
                <Button>Retour aux services</Button>
            </a>
            <h1 className="text-2xl font-bold text-center">Fiche service</h1>
            <div className="my-10">
                <p className="font-bold">Date: {dateLocaleFormat(mealTime.date.timestamp)}</p>
                <p>Service: {mealTime.service}</p>
                <p>Status: {mealTime.open ? 'Ouvert' : 'Fermé'}</p>
            </div>
            <a href={editLink}>
                <Button>Modifier ce mealTime</Button>
            </a>
        </div>
    );
}
