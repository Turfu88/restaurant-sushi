import React from 'react';
import { Button } from '@/components/ui/button';


export function AppView() {
    const product = JSON.parse(document.querySelector('.data-js').getAttribute('data-product'));
    const editLink = `/products/${product.id}/edit`;
    const productListLink = '/products';

    return (
        <div className="mt-5 px-5">
            <a href={productListLink}>
                <Button>Retour aux produits</Button>
            </a>
            <h1 className="text-2xl font-bold text-center">Fiche produit</h1>
            <div className="my-10">
                <p className="font-bold">Nom: {product.label}</p>
                <p>Prix: {product.price}</p>
                <p>Description: {product.details}</p>
            </div>
            <a href={editLink}>
                <Button>Modifier ce produit</Button>
            </a>
        </div>
    );
}
