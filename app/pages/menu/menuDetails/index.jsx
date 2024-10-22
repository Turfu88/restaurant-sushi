import React from 'react';
import { Button } from '@/components/ui/button';


export function AppView() {
    const menu = JSON.parse(document.querySelector('.data-js').getAttribute('data-menu'));
    const editLink = `/menus/${menu.id}/edit`;
    const menuListLink = '/menus';

    return (
        <div className="mt-5 px-5">
            <a href={menuListLink}>
                <Button>Retour aux menus</Button>
            </a>
            <h1 className="text-2xl font-bold text-center">Fiche menu</h1>
            <div className="my-10">
                <p className="font-bold">Nom: {menu.title}</p>
                <p>Description: {menu.description}</p>
            </div>
            <a href={editLink}>
                <Button>Modifier ce menu</Button>
            </a>
        </div>
    );
}
