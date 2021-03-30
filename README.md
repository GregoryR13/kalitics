# kalitics
Exercice de développement Symfony4
## Table des matières
* [Informations générales](#informations-générales)
* [Technologies](#technologies)
* [Installation](#installation)
* [Démarrage](#démarrage)
* [Versions](#versions)
* [Auteur](#auteur)

## Informations générales
Bien que le design ne soit pas important sur cet exercice, un minimum d’attention sera porté à l’ergonomie
générale.

## Technologies
Projet développé avec :
* [Symfony](https://symfony.com/) : 4.4
* PHP: 8.02
* Mysql: 15.1

## Installation
1. Clôner le projet :

```
git clone https://github.com/GregoryR13/kalitics.git
```

2. Se diriger dans le dossier kalitics sur le terminal jusqu'à : 
```
cd kalitics
```
3. Installer toutes les dépendances composer du projet : 
```
composer install
```
4. Créer la base de données MySQL.
Pour paramétrer la création de votre base de données, allez dans le fichier .env du projet, et modifier la variable d'environnement selon vos paramètres : 
```
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7"
#exemple : DATABASE_URL="mysql://root:@127.0.0.1:3306/kalitics"
```
5. Puis exécuter la création de la base de données avec la commande :
```
php bin/console doctrine:database:create
```
6. Exécuter la migration en base de donnée :
```
php bin/console doctrine:migration:migrate
```

## Démarrage

Pour lancer l'application, il ne vous reste plus qu'à vous diriger sur ``/kalitics/public/``.

## Versions

**Version** 0.0.1

## Auteur
* **Grégory Rouan** _alias_  [@GregoryR13](https://github.com/GregoryR13)
