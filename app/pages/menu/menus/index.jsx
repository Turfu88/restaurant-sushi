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
import { Pencil, Eye, Receipt } from 'lucide-react';

export function AppView() {
    const menus = JSON.parse(document.querySelector('.data-js').getAttribute('data-menus'));

    return (
        <div className="mt-5 px-5">
            <a href="/dashboard">
                <Button>Retour au dashboard</Button>
            </a>
            <h1 className="text-2xl font-bold text-center">Page des menus</h1>
            <h2 className="font-bold mt-10 mb-5">Liste des menus</h2>
            {menus.length === 0 ?
                <p className='text-center mb-10'>Aucun menu enregistré</p>
                :
                <div className="rounded-md border mb-5">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead className="font-bold">Menu</TableHead>
                                <TableHead className="font-bold">Etablissement</TableHead>
                                <TableHead className="w-[200px] text-center font-bold">Consulter</TableHead>
                                <TableHead className="w-[200px] text-center font-bold">Modifier</TableHead>
                                <TableHead className="w-[200px] text-center font-bold">Produits</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {menus.map((menu) => (
                                <TableRow key={menu.id}>
                                    <TableCell className="font-medium">{menu.title}</TableCell>
                                    <TableCell className="font-medium">{menu.establishment.name}</TableCell>
                                    <TableCell>
                                        <a href={`/menus/${menu.id}`}>
                                            <div className="flex flex-row justify-center">
                                                <Eye />
                                            </div>
                                        </a>
                                    </TableCell>
                                    <TableCell>
                                        <a href={`/menus/${menu.id}/edit`}>
                                            <div className="flex flex-row justify-center">
                                                <Pencil />
                                            </div>
                                        </a>
                                    </TableCell>
                                    <TableCell>
                                        <a href={`/menus/${menu.id}/composer`}>
                                            <div className="flex flex-row justify-center">
                                                <Receipt />
                                            </div>
                                        </a>
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </div>
            }
            <a href="/menus/new">
                <Button>Créer un nouveau menu</Button>
            </a>
        </div>
    );
}
