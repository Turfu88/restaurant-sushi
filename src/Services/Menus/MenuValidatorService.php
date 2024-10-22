<?php

namespace App\Services\Menus;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MenuValidatorService
{
    /**
     * Valide le formulaire de menu
     * @return void Mais retourne une erreur si le formulaire n'est pas valide.
     */
    public function validate($menuForm): void
    {
        if (is_null($menuForm['establishment'])) {
            throw new BadRequestHttpException('Etablissemement non valide', null, 400);
        }
    }
}
