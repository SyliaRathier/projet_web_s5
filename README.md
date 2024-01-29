**Membre du groupe :**

Henchiri Adam
Rathier Sylia
Bettinger Sarah
Harribaud Kim

Hébergement sur serveur de l'IUT

MyAvatar: 
COSMETIPS API : https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api
COSMETIPS VueJS : https://webinfo.iutmontp.univ-montp2.fr/~henchiria/frontend/dist/

Répertoire GitHub

MyAvatar : https://github.com/AdamHenchiri/MyAvatar/tree/main
Popotion API : https://github.com/SyliaRathier/projet_web_s5
Popotion VueJS : https://github.com/SyliaRathier/vue_projet_s5

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

login: adamax,
password: Adamaxaumaxdepuis2002

