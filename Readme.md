# Photo Select Pro

---
App Web de selection de photo en plusieurs étapes, en Binôme en groupe de Thématique. 


---

## Pour commencer

### Prérequis

- Git 2.38.1
- PHP 8.2.12
- XDebug 3.2.0
- Composer 2.3.3
- Symfony cli  5.6.2
- Symfony 6.3.7
- npm 10.2.0
- node 21.1.0

## Installation

N'oubliez pas de dupliquer le fichier ``.env`` en ``.env.local`` afin d'y introduire votre propre réglage local.
Faite en sorte que toutes les variables d'environnement soient disponibles.

Seule la variable env ``DATABASE_URL`` sera à mettre à jour,
A vous de faire votre choix :
- Mysql
- PostGresQl
- MariaDb

Une fois que c'est fait

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


- Une fois le tout installé.
  - Server Symfony :  
    `symfony serve -d`   
    `php bin/console serve:start` 
  - Server Node :  
      `npm run build` ou
      `npm run watch`
  - Conteneur Docker :  
        `docker-compose up --build`  
        Attention Les conteneurs sont PostgreQl et PGAdmin 4
  


## Fabriquer avec
- [PHPStorm](https://www.jetbrains.com/fr-fr/phpstorm/) - IDE.
- [Tailwindcss](https://tailwindcss.com/) - Framework css utilisé pour ce projet