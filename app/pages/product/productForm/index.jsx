import React from 'react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import *  as Yup from 'yup';
import { Formik, Form } from 'formik';
import { Textarea } from '@/components/ui/textarea';
import { postProduct, patchProduct } from '@services/productService';

const productSchema = Yup.object().shape({
    label: Yup.string().required('Veuillez renseigner ce champ'),
    details: Yup.string().required('Veuillez renseigner ce champ'),
    price: Yup.number().required('Veuillez renseigner ce champ'),
});

export function AppView() {
    const productData = document.querySelector('.data-js').getAttribute('data-product');
    const productListLink = '/products';

    async function productSubmitHandler(values) {
        if (productData) {
            await patchProduct(values);
        } else {
            await postProduct(values);
        }
        window.location.href = productListLink;
    }

    return (
        <div className="mt-5 px-5">
            <a href={productListLink}>
                <Button>Retour aux produits</Button>
            </a>
            <h1 className="text-2xl font-bold text-center mb-10">Editeur de produit</h1>

            <Formik
                initialValues={productData ? JSON.parse(productData) : { label: '', details: '', price: '' }}
                validationSchema={productSchema}
                onSubmit={productSubmitHandler}
            >
                {formik => (
                    <Form onSubmit={formik.handleSubmit} className='flex justify-center flex-col items-center'>
                        <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                            <Label htmlFor="label">Nom du produit</Label>
                            <Input
                                type="text"
                                id="label"
                                placeholder="Nom du produit"
                                onChange={formik.handleChange}
                                value={formik.values.label}
                            />
                        </div>
                        <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                            <Label htmlFor="details">Description</Label>
                            <Textarea
                                placeholder="Description du produit"
                                id="details"
                                onChange={formik.handleChange}
                                value={formik.values.details}    
                            />
                        </div>
                        <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                            <Label htmlFor="price">Prix en €</Label>
                            <Input
                                type="number"
                                id="price"
                                placeholder="0.00"
                                onChange={formik.handleChange}
                                value={formik.values.price}
                            />
                        </div>
                        <div>
                            <Button type="submit">Enregistrer</Button>
                        </div>
                    </Form>
                )}
            </Formik>
        </div>
    );
}
