import React from 'react';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { Pencil, Eye } from 'lucide-react';

export function AppView() {
    const bookings = JSON.parse(document.querySelector('.data-js').getAttribute('data-bookings'));

    return (
        <div className="mt-5 px-5">
            <a href="/dashboard">
                <Button>Retour au dashboard</Button>
            </a>
            <h1 className="text-2xl font-bold text-center">Page des réservations</h1>
            <h2 className="font-bold mt-10 mb-5">Liste des réservations</h2>
            {bookings.length === 0 ?
                <p className='text-center mb-10'>Aucune réservation enregistrée</p>
                :
                <div className="rounded-md border mb-5">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead className="font-bold">Etablissement</TableHead>
                                <TableHead className="font-bold text-center">Nom</TableHead>
                                <TableHead className="font-bold text-center">Personnes</TableHead>
                                <TableHead className="w-[200px] text-center font-bold">Consulter</TableHead>
                                <TableHead className="w-[200px] text-center font-bold">Modifier</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {bookings.map((booking) => (
                                <TableRow key={booking.id}>
                                    <TableCell className="font-medium">{booking.establishment.name}</TableCell>
                                    <TableCell className="font-medium text-center">{booking.name}</TableCell>
                                    <TableCell className="font-medium text-center">{booking.peopleNumber}</TableCell>
                                    <TableCell>
                                        <a href={`/bookings/${booking.id}`}>
                                            <div className="flex flex-row justify-center">
                                                <Eye />
                                            </div>
                                        </a>
                                    </TableCell>
                                    <TableCell>
                                        <a href={`/bookings/${booking.id}/edit`}>
                                            <div className="flex flex-row justify-center">
                                                <Pencil />
                                            </div>
                                        </a>
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </div>
            }
            <a href="/bookings/new">
                <Button>Créer une nouvelle réservation</Button>
            </a>
        </div>
    );
}
