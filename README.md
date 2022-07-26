# Installation

## Contexte
Vous venez d’intégrer une startup dont le cœur de métier est une application permettant de gérer ses tâches quotidiennes. L’entreprise vient tout juste d’être montée, et l’application a dû être développée à toute vitesse pour permettre de montrer à de potentiels investisseurs que le concept est viable (on parle de Minimum Viable Product ou MVP).

Le choix du développeur précédent a été d’utiliser le framework PHP Symfony, un framework que vous commencez à bien connaître ! 

Bonne nouvelle ! ToDo & Co a enfin réussi à lever des fonds pour permettre le développement de l’entreprise et surtout de l’application.

Votre rôle ici est donc d’améliorer la qualité de l’application. La qualité est un concept qui englobe bon nombre de sujets : on parle souvent de qualité de code, mais il y a également la qualité perçue par l’utilisateur de l’application ou encore la qualité perçue par les collaborateurs de l’entreprise, et enfin la qualité que vous percevez lorsqu’il vous faut travailler sur le projet.

Ainsi, pour ce dernier projet de spécialisation, vous êtes dans la peau d’un développeur expérimenté en charge des tâches suivantes :

l’implémentation de nouvelles fonctionnalités ;
la correction de quelques anomalies ;
et l’implémentation de tests automatisés.
Il vous est également demandé d’analyser le projet grâce à des outils vous permettant d’avoir une vision d’ensemble de la qualité du code et des différents axes de performance de l’application.

Il ne vous est pas demandé de corriger les points remontés par l’audit de qualité de code et de performance. Cela dit, si le temps vous le permet, ToDo & Co sera ravi que vous réduisiez la dette technique de cette application.

## Description du besoin

### Corrections d'anomalies
#### Une tâche doit être attachée à un utilisateur
Actuellement, lorsqu’une tâche est créée, elle n’est pas rattachée à un utilisateur. Il vous est demandé d’apporter les corrections nécessaires afin qu’automatiquement, à la sauvegarde de la tâche, l’utilisateur authentifié soit rattaché à la tâche nouvellement créée.

Lors de la modification de la tâche, l’auteur ne peut pas être modifié.

Pour les tâches déjà créées, il faut qu’elles soient rattachées à un utilisateur “anonyme”.

#### Choisir un rôle pour un utilisateur
Lors de la création d’un utilisateur, il doit être possible de choisir un rôle pour celui-ci. Les rôles listés sont les suivants :

rôle utilisateur (ROLE_USER) ;
rôle administrateur (ROLE_ADMIN).
Lors de la modification d’un utilisateur, il est également possible de changer le rôle d’un utilisateur.

### Implémentation de nouvelles fonctionnalités
#### Autorisation
Seuls les utilisateurs ayant le rôle administrateur (ROLE_ADMIN) doivent pouvoir accéder aux pages de gestion des utilisateurs.

Les tâches ne peuvent être supprimées que par les utilisateurs ayant créé les tâches en question.

Les tâches rattachées à l’utilisateur “anonyme” peuvent être supprimées uniquement par les utilisateurs ayant le rôle administrateur (ROLE_ADMIN).

### Implémentation de tests automatisés
Il vous est demandé d’implémenter les tests automatisés (tests unitaires et fonctionnels) nécessaires pour assurer que le fonctionnement de l’application est bien en adéquation avec les demandes.

Ces tests doivent être implémentés avec PHPUnit ; vous pouvez aussi utiliser Behat pour la partie fonctionnelle.

Vous prévoirez des données de tests afin de pouvoir prouver le fonctionnement dans les cas explicités dans ce document.

Il vous est demandé de fournir un rapport de couverture de code au terme du projet. Il faut que le taux de couverture soit supérieur à 70 %.

## Identifiants administrateur
- ruiz.nico64@gmail.com
- Test64170

## Configuration nécessaire
- Serveur web local ou en ligne
- Système de gestion de base de données relationnelle MySQL
- Installer Composer sur sa machine

## Instructions d'installation

##### 1/ Récupérez le projet github 
```
git clone https://github.com/nicrz/todolist
```
##### 2/ Modifier le fichier .env avec vos informations de base de données
```
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7
```
##### 3/ Importez le fichier todolist.sql dans votre système de gestion de base de données

##### 4/ Récupérez les dépendances du projet grâce à la commande suivante
```
composer install
```
##### 5/ Lancez le serveur Symfony grâce à la commande suivante
```
php bin/console server:start
```
##### 5/ Vous pouvez accéder à votre application depuis l'adresse suivante
```
http://127.0.0.1:8000/
```
