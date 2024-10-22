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
import { Pencil, Eye, ArrowUpDown } from 'lucide-react';

export function AppView() {
    const staffMembers = JSON.parse(document.querySelector('.data-js').getAttribute('data-staff-members'));

    return (
        <div className="mt-5 px-5">
            <a href="/dashboard">
                <Button>Retour au dashboard</Button>
            </a>
            <h1 className="text-2xl font-bold text-center">Page des employés</h1>
            <h2 className="font-bold mt-10 mb-5">Liste des employés</h2>
            {staffMembers.length === 0 ?
                <p className='text-center mb-10'>Aucun employé enregistré</p>
                :
                <div className="rounded-md border mb-5">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead className="w-[200px] font-bold">Nom</TableHead>
                                <TableHead className="w-[200px] font-bold">Prénom</TableHead>
                                <TableHead className="w-[200px] font-bold">Rôle</TableHead>
                                <TableHead className="text-center font-bold">Consulter</TableHead>
                                <TableHead className="text-center font-bold">Modifier</TableHead>
                                <TableHead className="text-center font-bold">Affectations</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {staffMembers.map((staffMember) => (
                                <TableRow key={staffMember.id}>
                                    <TableCell className="font-medium">{staffMember.firstname}</TableCell>
                                    <TableCell className="font-medium">{staffMember.lastname}</TableCell>
                                    <TableCell className="font-medium">{staffMember.role}</TableCell>
                                    <TableCell>
                                        <a href={`/staff-members/${staffMember.id}`}>
                                            <div className="flex flex-row justify-center">
                                                <Eye />
                                            </div>
                                        </a>
                                    </TableCell>
                                    <TableCell>
                                        <a href={`/staff-members/${staffMember.id}/edit`}>
                                            <div className="flex flex-row justify-center">
                                                <Pencil />
                                            </div>
                                        </a>
                                    </TableCell>
                                    <TableCell>
                                        <a href={`/staff-members/${staffMember.id}/affectations`}>
                                            <div className="flex flex-row justify-center">
                                                <ArrowUpDown />
                                            </div>
                                        </a>
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </div>
            }
            <a href="/staff-members/new">
                <Button>Ajouter un nouvel employé</Button>
            </a>
        </div>
    );
}
