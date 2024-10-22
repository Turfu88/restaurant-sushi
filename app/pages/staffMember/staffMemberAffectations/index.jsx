import React, { useState } from 'react';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Checkbox } from '@/components/ui/checkbox';
import { addStaffMemberEstablishment, removeStaffMemberEstablishment } from '@services/staffMemberService';

export function AppView() {
    const staffMemberData = document.querySelector('.data-js').getAttribute('data-staff-member');
    const establishmentsData = document.querySelector('.data-js').getAttribute('data-establishments');

    const [staffMember, setStaffMember] = useState(JSON.parse(staffMemberData));
    const establishments = JSON.parse(establishmentsData);

    const staffMemberListLink = '/staff-members';

    async function handleToggleEstablishment(staffMemberId, establishmentId, value) {
        if (value === true) {
            const staffMemberUpdated = await addStaffMemberEstablishment(staffMemberId, establishmentId);
            setStaffMember(JSON.parse(staffMemberUpdated));
            return;
        }
        if (value === false) {
            const staffMemberUpdated = await removeStaffMemberEstablishment(staffMemberId, establishmentId);
            setStaffMember(JSON.parse(staffMemberUpdated));
        }
    }

    return (
        <div className="mt-5 px-5">
            <a href={staffMemberListLink}>
                <Button>Retour aux staffMembers</Button>
            </a>
            <h1 className="text-2xl font-bold text-center mb-10">Editeur d'affectations</h1>

            <div className='mb-5'>
                Employé concerné: <span className='font-bold'>{staffMember.firstname} {staffMember.lastname}</span>
            </div>

            <div className="grid w-full max-w-sm items-center gap-1.5 mb-10">
                <Label className="text-xl font-bold mb-2">Liste des établissements</Label>
                {establishments.map((establishment) => (
                    <div key={establishment.id} className="flex gap-2 mb-1">
                        <Checkbox
                            className="mt-1"
                            id={establishment.id}
                            checked={staffMember.establishments.some((staffMemberEstablishment) => staffMemberEstablishment.id === establishment.id)}
                            onCheckedChange={(value) => handleToggleEstablishment(staffMember.id, establishment.id, value)}
                        />
                        <label
                            htmlFor={establishment.id}
                            className="font-medium peer-disabled:cursor-not-allowed"
                        >
                            {establishment.name}
                        </label>
                    </div>
                ))}
            </div>
        </div>
    );
}
