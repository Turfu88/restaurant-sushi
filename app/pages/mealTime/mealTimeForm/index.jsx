import React from 'react';
import *  as Yup from 'yup';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group';
import { Formik, Form } from 'formik';
import { Switch } from '@/components/ui/switch';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { timestampToInputFormat} from '@/lib/dateFormat';
import { postMealTime, patchMealTime } from '@services/mealTimeService';

const mealTimeSchema = Yup.object().shape({
    date: Yup.string().required('Veuillez renseigner ce champ'),
    service: Yup.string().required('Veuillez renseigner ce champ'),
    establishment: Yup.number().required('Veuillez sélectionner un établissement'),
    open: Yup.boolean(),
});

export function AppView() {
    const mealTimeData = document.querySelector('.data-js').getAttribute('data-meal-time');
    const mealTime = mealTimeData ? JSON.parse(mealTimeData) : null;

    const establishmentsData = document.querySelector('.data-js').getAttribute('data-establishments');
    const establishments = JSON.parse(establishmentsData);

    if (mealTime) {
        mealTime.date = timestampToInputFormat(mealTime?.date?.timestamp);
    }

    const mealTimeListLink = '/meal-times';

    async function mealTimeSubmitHandler(values) {
        if (mealTimeData) {
            await patchMealTime(values);
        } else {
            await postMealTime(values);
        }
        window.location.href = mealTimeListLink;
    }

    return (
        <div className="mt-5 px-5">
            <a href={mealTimeListLink}>
                <Button>Retour aux Services</Button>
            </a>
            <h1 className="text-2xl font-bold text-center mb-10">Editeur de service</h1>

            <Formik
                initialValues={mealTime ? { ...mealTime, establishment: mealTime.establishment.id } : { date: '', service: '', open: true, establishment: null }}
                validationSchema={mealTimeSchema}
                onSubmit={mealTimeSubmitHandler}
            >
                {formik => (
                    <Form onSubmit={formik.handleSubmit} className='flex justify-center flex-col items-center'>
                        <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                            <Label className="mb-2">Service associé à l&apos;établissement</Label>
                            <RadioGroup
                                id="establishment"
                                onValueChange={(checked) => formik.setFieldValue('establishment', checked)}
                                //defaultValue={formik.values?.establishment ? formik.values.establishment.id : null}
                                defaultValue={mealTime ? mealTime.establishment.id : null}
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
                            <Label htmlFor="date">Date du service</Label>
                            <Input
                                type="date"
                                id="date"
                                placeholder="Nom du mealTime"
                                onChange={formik.handleChange}
                                value={formik.values?.date}
                            />
                        </div>
                        <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                            <Label htmlFor="service">Service de la journée</Label>
                            <Select
                                onValueChange={(value) => formik.setFieldValue('service', value)}
                                defaultValue={formik.values?.service ? formik.values.service : ''}
                                name="service"
                            >
                                <SelectTrigger>
                                    <SelectValue placeholder="Sélectionner un service" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectItem value="lunch">Midi</SelectItem>
                                        <SelectItem value="diner">Soir</SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </div>
                        <div className="flex items-center space-x-2 mb-10">
                            <Label htmlFor="open">Status du service</Label>
                            <Switch
                                id="open"
                                name="open"
                                checked={formik.values?.open}
                                onCheckedChange={(checked) => formik.setFieldValue('open', checked)}
                            />
                        </div>
                        <div>
                            <Button type="submit" onClick={() => console.log(formik.values)}>Enregistrer</Button>
                        </div>
                    </Form>
                )}
            </Formik>
        </div>
    );
}
