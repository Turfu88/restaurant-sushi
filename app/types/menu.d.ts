import { ProductForm } from '@models/product';

export interface MenuForm {
    id?: number;
    title: string;
    description: string;
    products?: ProductForm[];
}
