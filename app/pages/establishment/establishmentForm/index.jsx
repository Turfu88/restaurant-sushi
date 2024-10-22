import React from 'react';
import *  as Yup from 'yup';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from "@/components/ui/switch";
import { Formik, Form } from 'formik';
import { Textarea } from '@/components/ui/textarea';
import { postEstablishment, patchEstablishment } from '@services/establishmentService';

const establishmentSchema = Yup.object().shape({
    name: Yup.string().required('Veuillez renseigner ce champ'),
    address: Yup.string().required('Veuillez renseigner ce champ'),
    availableSeats: Yup.number().required('Veuillez renseigner ce champ'),
    timeLimitBeforeCancel: Yup.number().required('Veuillez renseigner ce champ'),
    open: Yup.boolean(),
    openingAdvancedBookingDays: Yup.number().required('Veuillez renseigner ce champ'),
});

export function AppView() {
    const establishmentData = document.querySelector('.data-js').getAttribute('data-establishment');
    const establishmentListLink = '/establishments';

    async function establishmentSubmitHandler(values) {
        if (establishmentData) {
            await patchEstablishment(values);
        } else {
            await postEstablishment(values);
        }
        window.location.href = establishmentListLink;
    }

    return (
        <div className="mt-5 px-5">
            <a href={establishmentListLink}>
                <Button>Retour à la liste</Button>
            </a>
            <h1 className="text-2xl font-bold text-center mb-10">Caractéristiques de l&apos;établissement</h1>

            <Formik
                initialValues={establishmentData ? JSON.parse(establishmentData) : {
                    name: '',
                    address: '',
                    availableSeats: 0,
                    timeLimitBeforeCancel: 0,
                    open: false,
                    openingAdvancedBookingDays: 0
                }}
                validationSchema={establishmentSchema}
                onSubmit={establishmentSubmitHandler}
            >
                {formik => (
                    <Form onSubmit={formik.handleSubmit} className='flex justify-center flex-col items-center'>
                        <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                            <Label htmlFor="label">Nom de l&apos;établissement</Label>
                            <Input
                                type="text"
                                id="name"
                                placeholder="Nom de l'établissement"
                                onChange={formik.handleChange}
                                value={formik.values.name}
                            />
                        </div>
                        <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                            <Label htmlFor="address">Adresse</Label>
                            <Textarea
                                placeholder="Adresse"
                                id="address"
                                onChange={formik.handleChange}
                                value={formik.values.address}
                            />
                        </div>
                        <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                            <Label htmlFor="availableSeats">Nombre de place assise</Label>
                            <Input
                                type="number"
                                id="availableSeats"
                                onChange={formik.handleChange}
                                value={formik.values.availableSeats}
                            />
                        </div>
                        <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                            <Label htmlFor="timeLimitBeforeCancel">
                                Temps limite de réservation (en minutes)
                            </Label>
                            <Input
                                type="number"
                                id="timeLimitBeforeCancel"
                                placeholder="30"
                                onChange={formik.handleChange}
                                value={formik.values.timeLimitBeforeCancel}
                            />
                        </div>
                        <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                            <Label htmlFor="openingAdvancedBookingDays">
                                Ouverture des réservations en avance (en jours)
                            </Label>
                            <Input
                                type="number"
                                id="openingAdvancedBookingDays"
                                placeholder="5"
                                onChange={formik.handleChange}
                                value={formik.values.openingAdvancedBookingDays}
                            />
                        </div>
                        <div className="flex items-center space-x-2 mb-10">
                            <Label htmlFor="open">Status de l&apos;établissement</Label>
                            <Switch
                                id="open"
                                name="open"
                                checked={formik.values.open}
                                onCheckedChange={(checked) => formik.setFieldValue('open', checked)}
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
