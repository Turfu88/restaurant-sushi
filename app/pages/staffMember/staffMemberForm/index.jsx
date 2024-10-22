import React from 'react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import *  as Yup from 'yup';
import { Formik, Form } from 'formik';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { WandSparkles } from 'lucide-react';
import { postStaffMember, patchStaffMember } from '@services/staffMemberService';
import { generateUsername } from "@/lib/usernameGenerator";

const staffMemberSchema = Yup.object().shape({
    firstname: Yup.string().required('Veuillez renseigner ce champ'),
    lastname: Yup.string().required('Veuillez renseigner ce champ'),
    role: Yup.string().required('Veuillez renseigner ce champ'),
});

const staffMemberAndUserSchema = Yup.object().shape({
    firstname: Yup.string().required('Veuillez renseigner ce champ'),
    lastname: Yup.string().required('Veuillez renseigner ce champ'),
    role: Yup.string().required('Veuillez renseigner ce champ'),
    username: Yup.string().required('Veuillez renseigner ce champ'),
    password: Yup.string().required('Veuillez renseigner ce champ'),
});

export function AppView() {
    const staffMemberData = document.querySelector('.data-js').getAttribute('data-staff-member');
    const staffMembersListLink = '/staff-members';

    async function staffMemberSubmitHandler(values) {
        if (staffMemberData) {
            await patchStaffMember(values);
        } else {
            await postStaffMember(values);
        }
        window.location.href = staffMembersListLink;
    }

    function handleGenerateUsername(formik) {
        const username = generateUsername();
        formik.setFieldValue('username', username)
    }

    return (
        <div className="mt-5 px-5">
            <a href={staffMembersListLink}>
                <Button>Retour à la liste</Button>
            </a>
            <h1 className="text-2xl font-bold text-center mb-10">Formulaire employé</h1>

            <Formik
                initialValues={staffMemberData ?
                    JSON.parse(staffMemberData) :
                    {
                        firstname: '',
                        lastname: '',
                        role: '',
                        username: '',
                        password: ''
                    }
                }
                validationSchema={staffMemberData ? staffMemberSchema : staffMemberAndUserSchema}
                onSubmit={staffMemberSubmitHandler}
            >
                {formik => (
                    <Form onSubmit={formik.handleSubmit} className='flex justify-center flex-col items-center'>
                        <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                            <Label htmlFor="firstname">Prénom de l&apos;employé</Label>
                            <Input
                                type="text"
                                id="firstname"
                                placeholder="Prénom de l'employé"
                                onChange={formik.handleChange}
                                value={formik.values.firstname}
                            />
                        </div>
                        <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                            <Label htmlFor="lastname">Nom de l&apos;employé</Label>
                            <Input
                                type="text"
                                id="lastname"
                                placeholder="Nom de l'employé"
                                onChange={formik.handleChange}
                                value={formik.values.lastname}
                            />
                        </div>
                        <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                            <Label htmlFor="role">Rôle de l&apos;employé</Label>
                            <Select
                                onValueChange={(value) => formik.setFieldValue('role', value)}
                                defaultValue={formik.values.role ? formik.values.role : ''}
                                name="role"
                            >
                                <SelectTrigger>
                                    <SelectValue placeholder="Sélectionner un rôle" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectItem value="kitchen">Cuisine</SelectItem>
                                        <SelectItem value="service">Service</SelectItem>
                                        <SelectItem value="management">Management</SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </div>
                        {!staffMemberData && (
                            <>
                                <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                                    <Label htmlFor="username">Identifiant de l&apos;employé</Label>
                                    <div className='flex gap-1'>
                                        <Input
                                            type="text"
                                            id="username"
                                            placeholder="Identifiant de l'employé"
                                            onChange={formik.handleChange}
                                            value={formik.values.username}
                                        />
                                        <Button type="button" onClick={() => handleGenerateUsername(formik)}>
                                            <WandSparkles />
                                        </Button>
                                    </div>

                                </div>
                                <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                                    <Label htmlFor="password">Mot de passe de l&apos;employé</Label>
                                    <Input
                                        type="password"
                                        id="password"
                                        placeholder="Mot de passe"
                                        onChange={formik.handleChange}
                                        value={formik.values.password}
                                    />
                                </div>
                            </>
                        )}
                        <div>
                            <Button type="submit">Enregistrer</Button>
                        </div>
                    </Form>
                )}
            </Formik>
        </div>
    );
}
