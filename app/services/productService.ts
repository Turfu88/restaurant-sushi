import request from '@services/request';
import { ProductForm } from '@models/product';

export async function postProduct(values: ProductForm) {
    return await request(`/api/products/new`, 'POST', values, true).then((res) => {
        if (res.status === 200) {
            return res.json;
        }
        return null;
    })
}

export async function patchProduct(values: ProductForm) {
    return await request(`/api/products/${values.id}/edit`, 'PATCH', values, true).then((res) => {
        if (res.status === 200) {
            return res.json;
        }
        return null;
    })
}
