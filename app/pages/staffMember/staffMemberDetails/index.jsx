import React from 'react';
import { Button } from '@/components/ui/button';


export function AppView() {
    const staffMember = JSON.parse(document.querySelector('.data-js').getAttribute('data-staff-member'));
    const editLink = `/staffMember/${staffMember.id}/edit`;
    const staffMemberListLink = '/staff-members';

    return (
        <div className="mt-5 px-5">
            <a href={staffMemberListLink}>
                <Button>Retour à la liste des employés</Button>
            </a>
            <h1 className="text-2xl font-bold text-center">Fiche employé</h1>
            <div className="my-10">
                <p className="font-bold">Nom: {staffMember.firstname}</p>
                <p>Prénom: {staffMember.lastname}</p>
                <p>Rôle: {staffMember.role}</p>
            </div>
            <a href={editLink}>
                <Button>Modifier les informations de l'employé</Button>
            </a>
        </div>
    );
}
