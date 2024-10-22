import request from '@services/request';
import { MealTimeForm } from '@models/mealTime';

export async function postMealTime(values: MealTimeForm) {
    return await request(`/api/meal-times/new`, 'POST', values, true).then((res) => {
        if (res.status === 200) {
            return res.json;
        }
        return null;
    })
}

export async function patchMealTime(values: MealTimeForm) {
    return await request(`/api/meal-times/${values.id}/edit`, 'PATCH', values, true).then((res) => {
        if (res.status === 200) {
            return res.json;
        }
        return null;
    })
}