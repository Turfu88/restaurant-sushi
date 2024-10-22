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
import { dateLocaleFormat } from '@/lib/dateFormat';
import { Pencil, Eye } from 'lucide-react';

export function AppView() {
    const mealTimes = JSON.parse(document.querySelector('.data-js').getAttribute('data-meal-times'));

    return (
        <div className="mt-5 px-5">
            <a href="/dashboard">
                <Button>Retour au dashboard</Button>
            </a>
            <h1 className="text-2xl font-bold text-center">Page des services</h1>
            <h2 className="font-bold mt-10 mb-5">Liste des services</h2>
            {mealTimes.length === 0 ?
                <p className='text-center mb-10'>Aucun service enregistré</p>
                :
                <div className="rounded-md border mb-5">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead className="font-bold">Etablissement</TableHead>
                                <TableHead className="font-bold">Jour</TableHead>
                                <TableHead className="font-bold">Service</TableHead>
                                <TableHead className="font-bold">Status</TableHead>
                                <TableHead className="w-[200px] text-center font-bold">Consulter</TableHead>
                                <TableHead className="w-[200px] text-center font-bold">Modifier</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {mealTimes.map((mealTime) => (
                                <TableRow key={mealTime.id}>
                                    <TableCell className="font-medium">{mealTime.establishment.name}</TableCell>
                                    <TableCell className="font-medium">{dateLocaleFormat(mealTime.date.timestamp)}</TableCell>
                                    <TableCell className="font-medium">{mealTime.service}</TableCell>
                                    <TableCell className="font-medium">{mealTime.open ? 'Ouvert' : 'Fermé'}</TableCell>
                                    <TableCell>
                                        <a href={`/meal-times/${mealTime.id}`}>
                                            <div className="flex flex-row justify-center">
                                                <Eye />
                                            </div>
                                        </a>
                                    </TableCell>
                                    <TableCell>
                                        <a href={`/meal-times/${mealTime.id}/edit`}>
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
            <a href="/meal-times/new">
                <Button>Créer un nouveau service</Button>
            </a>
        </div>
    );
}
