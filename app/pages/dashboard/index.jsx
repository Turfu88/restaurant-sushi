import React from 'react';
import { Button } from '@/components/ui/button';

export function AppView() {

    return (
        <div className="mt-5 px-5">
            <h1 className="text-2xl font-bold">On est sur le dashboard</h1>
            <a href="/">
                <Button>Go to Homepage</Button>
            </a>
            <div className='mt-10'>
                <a href="/products">
                    <Button>Produits</Button>
                </a>
            </div>
            <div className='mt-10'>
                <a href="/menus">
                    <Button>Menus</Button>
                </a>
            </div>
            <div className='mt-10'>
                <a href="/establishments">
                    <Button>Etablissements</Button>
                </a>
            </div>
            <div className='mt-10'>
                <a href="/staff-members">
                    <Button>Staff</Button>
                </a>
            </div>
            <div className='mt-10'>
                <a href="/meal-times">
                    <Button>Services</Button>
                </a>
            </div>
            <div className='mt-10'>
                <a href="/bookings">
                    <Button>Réservations</Button>
                </a>
            </div>
        </div>
    );
}
