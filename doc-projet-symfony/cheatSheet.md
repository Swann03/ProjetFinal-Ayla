Allumer le serveur

symfony serve
symfony server:start
symfony server:stop

## Après clonage d'un repo

composer install
(Si dépencence de JS - npm install)

## GIT

git add .
git commit -m "message du commiy"
git remote add origin https://repogit... #rajouter un repo remote
git remote remove origin #supprimer le lien avec le repo remote

## Symfony

Après avoir configuré le fichier .env avec la connexion 

# Rajouter les packages pour l'ORM

symfony console req symfony/orm-pack
symfony composer req symfony/maler-bundle --dev

# Lancer la création de la BD
symfony console doctrine:database:create

# Création/update des entités
symfony console make:entity

(valable pour créer une nouvelle ou rajouter de propriétés à une existante)

# Créer une migration, la lancer

symfony console make:migration
symfony console doctrine:migrations:migrate