import React from 'react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import *  as Yup from 'yup';
import { Formik, Form } from 'formik';
import { Textarea } from '@/components/ui/textarea';
import { postMenu, patchMenu } from '@services/menuService';

const menuSchema = Yup.object().shape({
    title: Yup.string().required('Veuillez renseigner ce champ'),
    description: Yup.string().required('Veuillez renseigner ce champ'),
    establishment: Yup.number().required('Veuillez sélectionner un établissement'),
});

export function AppView() {
    const menuData = document.querySelector('.data-js').getAttribute('data-menu');
    const establishmentsData = document.querySelector('.data-js').getAttribute('data-establishments');
    const establishments = JSON.parse(establishmentsData);

    const menuListLink = '/menus';

    async function menuSubmitHandler(values) {
        if (menuData) {
            await patchMenu(values);
        } else {
            await postMenu(values);
        }
        window.location.href = menuListLink;
    }

    return (
        <div className="mt-5 px-5">
            <a href={menuListLink}>
                <Button>Retour aux menus</Button>
            </a>
            <h1 className="text-2xl font-bold text-center mb-10">Editeur de menu</h1>

            <Formik
                initialValues={menuData ? JSON.parse(menuData) : { title: '', description: '', establishment: null }}
                validationSchema={menuSchema}
                onSubmit={menuSubmitHandler}
            >
                {formik => (
                    <Form onSubmit={formik.handleSubmit} className='flex justify-center flex-col items-center'>
                        <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                            <Label htmlFor="title">Nom du menu</Label>
                            <Input
                                type="text"
                                id="title"
                                placeholder="Nom du menu"
                                onChange={formik.handleChange}
                                value={formik.values.title}
                            />
                        </div>
                        <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                            <Label htmlFor="description">Description</Label>
                            <Textarea
                                placeholder="Description du menu"
                                id="description"
                                onChange={formik.handleChange}
                                value={formik.values.description}
                            />
                        </div>
                        <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                            <Label className="mb-2">Menu associé à l&apos;établissement</Label>
                            <RadioGroup
                                id="establishment"
                                onValueChange={(checked) => formik.setFieldValue('establishment', checked)}
                                defaultValue={formik.values.establishment ? formik.values.establishment.id : establishments[0].id}
                            >
                                {establishments.map((establishment, index) => (
                                    <div key={index} className="flex items-center space-x-2">
                                        <RadioGroupItem value={establishment.id} id={"establishment_" + index} />
                                        <Label htmlFor={"establishment_" + index}>{establishment.name}</Label>
                                    </div>
                                ))}
                            </RadioGroup>
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
