import request from '@services/request';
import { MenuForm } from '@models/menu';

export async function postMenu(values: MenuForm) {
    return await request(`/api/menus/new`, 'POST', values, true).then((res) => {
        if (res.status === 200) {
            return res.json;
        }
        return null;
    })
}

export async function patchMenu(values: MenuForm) {
    return await request(`/api/menus/${values.id}/edit`, 'PATCH', values, true).then((res) => {
        if (res.status === 200) {
            return res.json;
        }
        return null;
    })
}

export async function addMenuProduct(menuId: number, productId: number) {
    const values = { action: 'add', productId };
    return await request(`/api/menus/${menuId}/product-toggle`, 'POST', values, true).then((res) => {
        if (res.status === 200) {
            return res.json;
        }
        return null;
    })
}

export async function removeMenuProduct(menuId: number, productId: number) {
    const values = { action: 'remove', productId };
    return await request(`/api/menus/${menuId}/product-toggle`, 'POST', values, true).then((res) => {
        if (res.status === 200) {
            return res.json;
        }
        return null;
    })
}

