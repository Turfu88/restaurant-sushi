import React, { useState } from 'react';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import { addMenuProduct, removeMenuProduct } from '@services/menuService';

export function AppView() {
    const menuData = document.querySelector('.data-js').getAttribute('data-menu');
    const productsData = document.querySelector('.data-js').getAttribute('data-products');

    const [menu, setMenu] = useState(JSON.parse(menuData));
    const products = JSON.parse(productsData);

    const menuListLink = '/menus';

    async function handleToggleProduct(menuId, productId, value) {
        if (value === true) {
            const menuUpdated = await addMenuProduct(menuId, productId);
            setMenu(JSON.parse(menuUpdated));
            return;
        }
        if (value === false) {
            const menuUpdated = await removeMenuProduct(menuId, productId);
            setMenu(JSON.parse(menuUpdated));
        }
    }

    return (
        <div className="mt-5 px-5">
            <a href={menuListLink}>
                <Button>Retour aux menus</Button>
            </a>
            <h1 className="text-2xl font-bold text-center mb-10">Editeur de menu</h1>

            <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                <Label className="text-xl font-bold mb-2">Liste des produits</Label>
                {products.map((product) => (
                    <div key={product.id} className="flex gap-2 mb-1">
                        <Checkbox
                            className="mt-1"
                            id={product.id}
                            //checked={menu.products.includes(product.id)}
                            checked={menu.products.some((menuProduct) => menuProduct.id === product.id)}
                            onCheckedChange={(value) => handleToggleProduct(menu.id, product.id, value)}
                        />
                        <label
                            htmlFor={product.id}
                            className="font-medium peer-disabled:cursor-not-allowed"
                        >
                            {product.label}
                        </label>
                    </div>
                ))}
            </div>
        </div>
    );
}
