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
    const establishments = JSON.parse(document.querySelector('.data-js').getAttribute('data-establishments'));

    return (
        <div className="mt-5 px-5">
            <a href="/dashboard">
                <Button>Retour au dashboard</Button>
            </a>
            <h1 className="text-2xl font-bold text-center">Page des établissements</h1>
            <h2 className="font-bold mt-10 mb-5">Liste des établissements</h2>
            <div className="rounded-md border mb-5">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead className="font-bold">Etablissement</TableHead>
                            <TableHead className="w-[200px] text-center font-bold">Status</TableHead>
                            <TableHead className="w-[200px] text-center font-bold">Places assises</TableHead>
                            <TableHead className="w-[200px] text-center font-bold">Heure limite de réservation</TableHead>
                            <TableHead className="w-[200px] text-center font-bold">Détails</TableHead>
                            <TableHead className="w-[200px] text-center font-bold">Modifier</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        {establishments.map((establishment) => (
                            <TableRow key={establishment.id}>
                                <TableCell className="font-medium">{establishment.name}</TableCell>
                                <TableCell className="font-medium text-center">{establishment.open ? 'Ouvert' : 'Fermé'}</TableCell>
                                <TableCell className="text-center">{establishment.availableSeats}</TableCell>
                                <TableCell className="font-medium text-center">{establishment.timeLimitBeforeCancel}</TableCell>
                                <TableCell>
                                    <a href={`/establishments/${establishment.id}`}>
                                        <div className="flex flex-row justify-center">
                                            <Eye />
                                        </div>
                                    </a>
                                </TableCell>
                                <TableCell>
                                    <a href={`/establishments/${establishment.id}/edit`}>
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

            <a href="/establishments/new">
                <Button>Ouvrir un nouvel establishment</Button>
            </a>

        </div>
    );
}
