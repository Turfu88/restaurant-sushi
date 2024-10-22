import React, { useState } from 'react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import *  as Yup from 'yup';
import { Formik, Form } from 'formik';
import { dateLocaleFormat } from '@/lib/dateFormat';

import { postBooking, patchBooking } from '@services/bookingService';

const bookingSchema = Yup.object().shape({
    name: Yup.string().required('Veuillez renseigner ce champ'),
    peopleNumber: Yup.number().required('Veuillez renseigner ce champ'),
    establishment: Yup.number().required('Veuillez sélectionner un établissement'),
    mealTime: Yup.number().required('Veuillez sélectionner un horaire de mélange'),
    phoneNumber: Yup.string()
});

export function AppView() {
    const bookingData = document.querySelector('.data-js').getAttribute('data-booking');
    const establishmentsData = document.querySelector('.data-js').getAttribute('data-establishments');
    const mealTimesData = document.querySelector('.data-js').getAttribute('data-meal-times');

    const establishments = JSON.parse(establishmentsData);
    const mealTimes = JSON.parse(mealTimesData);
    const booking = bookingData ? JSON.parse(bookingData) : null;
    if (booking) {
        booking.mealTime = booking.mealTime.id;
    }

    const [mealTimeOptions, setMealTimeOptions] = useState(
            bookingData
        ? 
            mealTimes.filter((mealTime) => mealTime.establishment.id === JSON.parse(bookingData).establishment.id)
        :
            null
        );

    const bookingListLink = '/bookings';

    async function bookingSubmitHandler(values) {
        if (bookingData) {
            await patchBooking(values);
        } else {
            await postBooking(values);
        }
        window.location.href = bookingListLink;
    }

    function handleUpdateMealTimeChoices(establishmentId) {
        setMealTimeOptions(mealTimes.filter((mealTime) => mealTime.establishment.id === establishmentId));
    }

    return (
        <div className="mt-5 px-5">
            <a href={bookingListLink}>
                <Button>Retour aux bookings</Button>
            </a>
            <h1 className="text-2xl font-bold text-center mb-10">{bookingData ? 'Modifier' : 'Créer'} une réservation</h1>

            <Formik
                initialValues={
                    booking ? { ...booking, establishment: booking.establishment.id } : { name: '', peopleNumber: '', establishment: null, phoneNumber: '', mealTime: null }
                }
                validationSchema={bookingSchema}
                onSubmit={bookingSubmitHandler}
            >
                {formik => (
                    <Form onSubmit={formik.handleSubmit} className='flex justify-center flex-col items-center'>
                        <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                            <Label className="mb-2">Réservation associée à l&apos;établissement</Label>
                            <RadioGroup
                                id="establishment"
                                onValueChange={(checked) => {
                                    handleUpdateMealTimeChoices(checked);
                                    formik.setFieldValue('establishment', checked);
                                }}
                                defaultValue={booking ? booking.establishment.id : null}
                            >
                                {establishments.map((establishment, index) => (
                                    <div key={index} className="flex items-center space-x-2">
                                        <RadioGroupItem value={establishment.id} id={"establishment_" + index} />
                                        <Label htmlFor={"establishment_" + index}>{establishment.name}</Label>
                                    </div>
                                ))}
                            </RadioGroup>
                        </div>
                        <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                            <Label htmlFor="name">Nom de la réservation (client)</Label>
                            <Input
                                type="text"
                                id="name"
                                placeholder="Nom du booking"
                                onChange={formik.handleChange}
                                value={formik.values.name}
                            />
                        </div>
                        <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                            <Label htmlFor="peopleNumber">Nombre de personnes</Label>
                            <Input
                                type="number"
                                placeholder="Nombre de personnes"
                                id="peopleNumber"
                                onChange={formik.handleChange}
                                value={formik.values.peopleNumber}
                            />
                        </div>
                        <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                            <Label htmlFor="phoneNumber">Contact téléphone</Label>
                            <Input
                                type="text"
                                id="phoneNumber"
                                placeholder="Téléphone"
                                onChange={formik.handleChange}
                                value={formik.values.phoneNumber}
                            />
                        </div>
                        {mealTimeOptions &&
                            mealTimeOptions.map((mealTime, index) => (
                                <div key={index} className="grid w-full max-w-sm items-center gap-1.5 mb-2">
                                    <Button
                                        type="button"
                                        onClick={() => formik.setFieldValue('mealTime', mealTime.id)}
                                        variant={formik.values.mealTime === mealTime.id ? '' : 'outline'}
                                    >
                                        {dateLocaleFormat(mealTime.date.timestamp)} - {mealTime.service}
                                    </Button>
                                </div>
                            ))
                        }
                        <div>
                            <Button type="submit" className="mt-10">Enregistrer</Button>
                        </div>
                    </Form>
                )}
            </Formik>
        </div>
    );
}
