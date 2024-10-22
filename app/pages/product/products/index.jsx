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
    const products = JSON.parse(document.querySelector('.data-js').getAttribute('data-products'));

    return (
        <div className="mt-5 px-5">
            <a href="/dashboard">
                <Button>Retour au dashboard</Button>
            </a>
            <h1 className="text-2xl font-bold text-center">Page des produits</h1>


            <h2 className="font-bold mt-10 mb-5">Liste des produits</h2>
            <div className="rounded-md border mb-5">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead className="font-bold">Produit</TableHead>
                            <TableHead className="w-[200px] text-center font-bold">Prix</TableHead>
                            <TableHead className="w-[200px] text-center font-bold">Détails</TableHead>
                            <TableHead className="w-[200px] text-center font-bold">Modifier</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        {products.map((product) => (
                            <TableRow key={product.id}>
                                <TableCell className="font-medium">{product.label}</TableCell>
                                <TableCell className="text-center">{product.price}</TableCell>
                                <TableCell>
                                    <a href={`/products/${product.id}`}>
                                        <div className="flex flex-row justify-center">
                                            <Eye />
                                        </div>
                                    </a>
                                </TableCell>
                                <TableCell>
                                    <a href={`/products/${product.id}/edit`}>
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

            <a href="/products/new">
                <Button>Ajouter un nouveau produit</Button>
            </a>

        </div>
    );
}
