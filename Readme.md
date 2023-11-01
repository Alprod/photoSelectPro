# Photo Select Pro

---
App Web de selection de photo en plusieurs étapes, en Binôme en groupe de Thématique. 


---

## Pour commencer

### Prérequis (au moment de la création du projet)

- Git 2.38.1
- PHP 8.2.12
- XDebug 3.2.0
- Composer 2.3.3
- Symfony cli 5.6.2
- Symfony 6.3.7
- npm 10.2.0
- node 21.1.0
- GNU Make 3.81

## Installation

N'oubliez pas de dupliquer le fichier ``.env`` en ``.env.local`` afin d'y introduire votre propre réglage local.
Faite en sorte que toutes les variables d'environnement soient disponibles.

Seule la variable env ``DATABASE_URL`` sera à mettre à jour,
À vous de faire votre choix :
- Mysql
- PostGresQl
- MariaDb

Une fois que c'est fait

Vous avez le choix de suivre l'initialisation du ``readme`` ou sinon d'utiliser le ``makefile``  

En faisant les commandes du ``makefile``  vous pourrez retrouver toutes les phases d'intallation :  

Avec ``make help`` retrouver la liste des commandes utiles.  

installer vendor `composer install`  
installer node `npm install`

La commande `symfony console` est à utiliser si vous avez Symfony-cli.
Comme précisé un peu plus haut

Installer votre BDD, la création de votre base ainsi que la migration des tables.
- Creation Bdd :  
  `php bin/console doctrine:database:create`  
  `symfony console doctrine:database:create`


- Migration des tables :  
    `php bin/console doctrine:migration:migrate`  
    `symfony console doctrine:migration:migrate`  


- Création de fausse donnés:  
    `php bin/console doctrine:fixtures:load`  
    `symfony console doctrine:fixtures:load`  


- Une fois le tout installé.
  - Server Symfony :  
    `symfony serve -d`   
    `php bin/console serve:start` 
  - Server Node :  
      `npm run build` ou
      `npm run watch`
  - Conteneur Docker :  
        `docker-compose up --build`  
        Attention Les conteneurs sont PostgreQl, PGAdmin 4 et d'une boite mail de test
  


## Fabriquer avec
- [PHPStorm](https://www.jetbrains.com/fr-fr/phpstorm/) - IDE.
- [Tailwindcss](https://tailwindcss.com/) - Framework css utilisé pour ce projet