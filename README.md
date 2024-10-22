# restaurant-sushi

Prérequis:
PhpMyAdmin ou autre
PHP 8.3
node 20.14 (le projet est très récent)

Mise en place du projet:
- git clone
- configurer le .env
- Lancer les migrations
- Lancer les fixtures de bases
- lancer les serveurs php/node: symfony server:start et yarn watch
- A partir de là on peut commencer à jouer avec

Non inclus dans le projet :
- Authentification + gestion droit des actions (même si la page login a été créée, elle n'est pas fonctionnelle)
- Quelques couleurs pour rendre l'appli un peu plus sexy
- Travail de front sur les pages publiques
- Un circuit de réservation pour les utilisateur anonymes
- De quoi ajouter des images sur le produits, les menus ou le profil des employés
- Passer les composants React en Typescript
- Mise en place d'une meilleure config d'eslint et prettier
- Un peu plus de tests pour une meilleure couverture même si on peut déjà en lancer quelques uns : php  bin/phpunit
- Quelques tests fonctionnels ou e2e

Pour info :
Cette application n'a pas vocation à être utilisée en contexte réel. Elle met l'accent sur la structure et l'architecture back/front avec Symfony (/src) et React (/app). La structure en MVC permet d'accueillir un grand nombre de modules par son extensibilité et le découplage de la base de donnée.
