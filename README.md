**Membre du groupe :**

Henchiri Adam
Rathier Sylia
Bettinger Sarah
Harribaud Kim

Hébergement sur serveur de l'IUT

MyAvatar:  https://webinfo.iutmontp.univ-montp2.fr/~henchiria/MyAvatar/myAvatar/public/ ( Noté que nous n'avons pas les droits pour installer tailwind css sur le répertoire de l'iut )
COSMETIPS API : https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api
COSMETIPS VueJS : https://webinfo.iutmontp.univ-montp2.fr/~henchiria/frontend/dist/

Répertoire GitHub

MyAvatar : https://github.com/AdamHenchiri/MyAvatar/tree/main
Cosmetips API : https://github.com/SyliaRathier/projet_web_s5
Cosmetips VueJS : https://github.com/SyliaRathier/vue_projet_s5

**Le thème**
Pour ce projet, nous avons choisi le thème des cosmétiques. Il consiste à répertorier des recettes de cosmétiques créées par les utilisateurs en détaillant les ingrédients et le matériel nécessaire. 

 
L’API de gestion de recettes de cosmétiques est un système permettant de gérer des données relatives à ces recettes.
L’API a été réalisée grâce au framework PHP Symfony et la librairie API Platform pour une API Rest.
La base de données utilisée est une base MySQL.
Pour la gestion des paiements des abonnements: intégration avec le système de paiement Stripe.

Les fonctionnalités principales de l’API sont:

**Gestion des recettes:** permet aux utilisateurs de créer, lire, mettre à jour et supprimer des recettes. Chaque recette comporte un titre, une description, des ingrédients, un prix, une durée, des catégories et du matériels. Il est possible de supprimer ou d’ajouter un ingrédient, sa quantité et son unité de mesure.

**Gestion des utilisateurs:** permet de créer des comptes utilisateurs, de se connecter et de gérer les profils. Les utilisateurs peuvent être des membres standard ou premium, ces derniers ayant accès à des fonctionnalités supplémentaires telles que l’ajout des liens vers leur propre site pour retrouver les ingrédients et matériels qu'ils proposent.

**Catégories et filtrage:** Les recettes peuvent être classées selon les catégories, ou selon un ingrédient, ou un matériel donné.

**Abonnement premium:** Intégration avec un système de paiement : Stripe, pour permettre aux utilisateurs de s’abonner et devenir membres premium.

**Authentification:** Protège les données des utilisateurs grâce à une authentification avec un JSON Web Token, permettant également la gestion des droits d’accès à certaines ressources

**Application VueJS**
L’application Vuejs représente l’interface graphique de notre application. Elle permet un affichage de nos données par l’intermédiaire de requêtes envoyées vers l'API. L'utilisateur peut donc profiter de toutes les fonctionnalités du site.


**Application MyAvatar**
Concernant le projet MyAvatar, le but est de crée une copie de Gravatar dont le but est de centralisée en un site toutes les photos de profil. A la fin il ne reste plus qu’a modifier la photo de profil sur le site pour la changer de partout.

Pour ce projet nous avons utiliser un projet symfony en server-side-rendering. Nous avons donc utiliser webpack encore pour la gestion des assets, et twig pour la création des templates.

Lorsqu’un utilisateur crée son compte il peut alors uploader sa photo de profile et celle si sera sauvegarder dans le dossier /public/uploads/profilepictures/ et le nom de celle-ci sera le hash en md5 de son addresse e-mail. De plus pour effecuter cette sauvegarde de fichier, nous avons utiliser la librairies vichuploader pour faciliter le téléchargement / stockage des photos de profiles. Grâce à des fichiers de configuration et des type pour les formulaire, cette librairie facilite tout le processus.


Investissement de chacun

Henchiri Adam : 34 
Rathier Sylia : 34
Bettinger Sarah : 20
Harribaud Kim : 12

Identifiant / Login
Popotion VueJS & API
Idnetifiants de test :

login: sarahb,
password: Sarahbettinger2002





**Guide d'Installation** :

**MyAvatar:**

Pour utiliser MyAvatar en local, suivez ces étapes :

* Clonez ce dépôt sur votre machine locale.
* Installez les dépendances avec la commande : 
```
composer install && npm i
```
* Installez Tailwind CSS : 
```
npm install -D tailwindcss && npx tailwindcss init
```
* Créez un fichier .env et configurez les variables d'environnement avec les informations de votre base de données, ainsi que pour le serveur de messagerie de développement : MAILER_DSN=smtp://localhost:1025.
* Exécutez les migrations pour créer la base de données :
```
php bin/console database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```
* Lancez l'application : 
```
symfony server:start
```
* Lancez Mail Dev : 
```
docker run -p 1080:1080 -p 1025:1025 maildev/maildev
```

**API COMSMETIPS:**
Pour utiliser l'API en local, suivez ces étapes :

* Clonez le projet depuis le dépôt GitHub ou récupérez le projet depuis le fichier .zip.
* Exécutez la commande composer avec la commande :
```
composer install
```
* Pour la base de données, récupérez le fichier docker-compose.yml et lancez-le avec la commande :
```
 docker compose up -d.
```
* Dans le fichier doctrine.yaml, configurez les ports et les informations sur la base de données. (Normalement déjà fait dans le fichier .zip)
* Dans le fichier .env, mettez la bonne URL pour la base de données : DATABASE_URL="mysql://root:root@localhost:3307/app?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
* Pour créer la base de données avec Doctrine, exécutez les commandes :

```
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```
* Lancez le serveur avec la commande : 
```
symfony server:start
```
* Vous devriez pouvoir accéder au site via l'URL proposée par Symfony. L'URL /api permet de voir l'API.

*Paiement et Passage au Statut Premium:*

* Lancer la commande :

```
stripe listen --forward-to https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/webhook/stripe
```
* Vous pouvez utiliser de fausses cartes proposées par Stripe pour tester le paiement : Cartes de Test Stripe

**VueJs COSMETIPS:**
Pour utiliser VueJs en local, suivez ces étapes :

* Clonez le projet depuis le dépôt GitHub ou récupérez le projet depuis le fichier .zip.
* Exécutez la commande : 
```
npm install
```
* Exécutez les commandes : 
```
npm install crypto-js
npm i vue-jwt-decode
```
* Pour lancer le serveur, exécutez la commande : 
```
npm run dev
```
* Autres informations : Dans le fichier .zip que nous avons rendu pour Vue.js, les URLs pour l'API sont celles du serveur de l'IUT. Il faudra donc changer les URLs pour le faire fonctionner avec l'API en local.




