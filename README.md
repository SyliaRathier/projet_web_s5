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

**Base de données de l'API :** 

![data](https://hackmd.io/_uploads/HyHKaiP9T.png)






```jsonld
{
	"info": {
		"_postman_id": "f2a3e629-4315-467c-b3c0-6d2a3f9e9aa6",
		"name": "S5_Recipe",
		"schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json",
		"_exporter_id": "32539238"
	},
	"item": [
		{
			"name": "Users",
			"item": [
				{
					"name": "GetAllUsers",
					"request": {
						"method": "GET",
						"header": [],
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/utilisateurs",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"utilisateurs"
							]
						}
					},
					"response": []
				},
				{
					"name": "CreateUser",
					"request": {
						"auth": {
							"type": "bearer"
						},
						"method": "POST",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": "{\r\n  \"login\": \"adama\",\r\n  \"adresseEmail\": \"adam@example.com\",\r\n  \"plainPassword\": \"OOxi0BnyrX2bvIegmJESBik075Pps\"\r\n}",
							"options": {
								"raw": {
									"language": "json"
								}
							}
						},
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/utilisateurs",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"utilisateurs"
							]
						}
					},
					"response": []
				},
				{
					"name": "GetUser/id",
					"protocolProfileBehavior": {
						"disableBodyPruning": true
					},
					"request": {
						"method": "GET",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": "",
							"options": {
								"raw": {
									"language": "json"
								}
							}
						},
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/utilisateurs/1",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"utilisateurs",
								"1"
							]
						}
					},
					"response": []
				},
				{
					"name": "DeleteUser/id",
					"request": {
						"method": "DELETE",
						"header": [],
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/utilisateurs/1",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"utilisateurs",
								"1"
							]
						}
					},
					"response": []
				},
				{
					"name": "New Request",
					"request": {
						"method": "PATCH",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": "{\r\n  \"login\": \"string\",\r\n  \"adresseEmail\": \"user@example.com\",\r\n  \"plainPassword\": \"fwlU1hfMkA2FmzdoMGQOUp\"\r\n}",
							"options": {
								"raw": {
									"language": "json"
								}
							}
						},
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/utilisateurs/1",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"utilisateurs",
								"1"
							]
						}
					},
					"response": []
				}
			]
		},
		{
			"name": "Stuff",
			"item": [
				{
					"name": "CreateStuff",
					"request": {
						"method": "POST",
						"header": [],
						"body": {
							"mode": "formdata",
							"formdata": [
								{
									"key": "nom",
									"value": "Étiquettes pour l'identification",
									"type": "text"
								},
								{
									"key": "description",
									"value": "Des étiquettes adhésives ou attachées au produit pour indiquer son contenu et d'autres informations.",
									"type": "text"
								},
								{
									"key": "prix",
									"value": "1",
									"type": "text"
								},
								{
									"key": "utilisation",
									"value": "Identifier les produits finis, lister les ingrédients et les instructions.",
									"type": "text"
								},
								{
									"key": "caractéristique",
									"value": "Facilite l'organisation et l'identification.",
									"type": "text"
								},
								{
									"key": "imageFile",
									"type": "file",
									"src": "/C:/Users/adamh/Pictures/Étiquettes pour l'identification.jpeg"
								},
								{
									"key": "lien",
									"value": "https://bit.ly/3ubyisi",
									"type": "text",
									"disabled": true
								},
								{
									"key": "utilisateur",
									"value": "http://localhost:8000/api/utilisateurs/1",
									"type": "text",
									"disabled": true
								}
							]
						},
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/materiels",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"materiels"
							]
						}
					},
					"response": []
				},
				{
					"name": "GetStuff/id",
					"request": {
						"method": "GET",
						"header": [],
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/materiels/1",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"materiels",
								"1"
							]
						}
					},
					"response": []
				},
				{
					"name": "DeleteStuff/id",
					"request": {
						"method": "DELETE",
						"header": [],
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/materiels/1",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"materiels",
								"1"
							]
						}
					},
					"response": []
				},
				{
					"name": "EditStuff/id",
					"request": {
						"method": "PATCH",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": "{\r\n  \"nom\": \"string\",\r\n  \"description\": \"string\",\r\n  \"prix\": 0,\r\n  \"utilisation\": \"string\",\r\n  \"caractéristique\": \"string\"\r\n}",
							"options": {
								"raw": {
									"language": "json"
								}
							}
						},
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/materiels/1",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"materiels",
								"1"
							]
						}
					},
					"response": []
				}
			]
		},
		{
			"name": "Recipe",
			"item": [
				{
					"name": "GetRecipe/idIngredient",
					"protocolProfileBehavior": {
						"disableBodyPruning": true
					},
					"request": {
						"method": "GET",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": "",
							"options": {
								"raw": {
									"language": "json"
								}
							}
						},
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/ingredients/{idIngredient}/quantite_ingredients/recettes",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"ingredients",
								"{idIngredient}",
								"quantite_ingredients",
								"recettes"
							]
						}
					},
					"response": []
				},
				{
					"name": "CreateRecipe",
					"request": {
						"method": "POST",
						"header": [],
						"body": {
							"mode": "formdata",
							"formdata": [
								{
									"key": "titre",
									"value": "Sérum Anti-Âge à la Rose",
									"type": "text"
								},
								{
									"key": "description",
									"value": "Un sérum riche en ingrédients anti-âge pour nourrir et régénérer la peau.",
									"type": "text"
								},
								{
									"key": "conseil",
									"value": "mettre des gants",
									"type": "text"
								},
								{
									"key": "ingredients",
									"value": "[\"http://localhost:8000/api/quantite_ingredients/7\"]",
									"type": "text"
								},
								{
									"key": "materiels",
									"value": "[\"http://localhost:8000/api/materiels/7\", \"http://localhost:8000/api/materiels/9\"]",
									"type": "text"
								},
								{
									"key": "duree",
									"value": "40Min",
									"type": "text"
								},
								{
									"key": "prix",
									"value": "10",
									"type": "text"
								},
								{
									"key": "utilisateur",
									"value": "http://localhost:8000/api/utilisateurs/1",
									"type": "text"
								},
								{
									"key": "imageFile",
									"type": "file",
									"src": "/C:/Users/adamh/Pictures/Sérum Anti-Âge à la Rose.jpg"
								}
							]
						},
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/recettes",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"recettes"
							]
						}
					},
					"response": []
				},
				{
					"name": "GetAllRecette",
					"request": {
						"method": "GET",
						"header": [],
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/recettes",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"recettes"
							]
						}
					},
					"response": []
				},
				{
					"name": "GetRecipe/id",
					"request": {
						"method": "GET",
						"header": [],
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/recettes/1",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"recettes",
								"1"
							]
						}
					},
					"response": []
				},
				{
					"name": "DeleteRecipe/id",
					"request": {
						"method": "DELETE",
						"header": [],
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/recettes/1",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"recettes",
								"1"
							]
						}
					},
					"response": []
				},
				{
					"name": "EditRecipe/id",
					"request": {
						"method": "PATCH",
						"header": [],
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/recettes/1",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"recettes",
								"1"
							]
						}
					},
					"response": []
				},
				{
					"name": "GetRecipe/idUser",
					"request": {
						"method": "GET",
						"header": [],
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/utilisateurs/1/recettes",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"utilisateurs",
								"1",
								"recettes"
							]
						}
					},
					"response": []
				}
			]
		},
		{
			"name": "Ingredient",
			"item": [
				{
					"name": "GetAllIngredient",
					"request": {
						"method": "GET",
						"header": [],
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/ingredients",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"ingredients"
							]
						}
					},
					"response": []
				},
				{
					"name": "CreateIngredient",
					"request": {
						"method": "POST",
						"header": [],
						"body": {
							"mode": "formdata",
							"formdata": [
								{
									"key": "nom",
									"value": "Argile Rouge",
									"type": "text"
								},
								{
									"key": "description",
									"value": "L'argile rouge est riche en fer et est souvent utilisee pour revitaliser la peau",
									"type": "text"
								},
								{
									"key": "prix",
									"value": "2.9",
									"type": "text"
								},
								{
									"key": "imageFile",
									"type": "file",
									"src": "/C:/Users/adamh/Pictures/Argile Rouge.jpeg"
								}
							]
						},
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/ingredients",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"ingredients"
							]
						}
					},
					"response": []
				},
				{
					"name": "GetIngredient/id",
					"request": {
						"method": "GET",
						"header": [],
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/ingredients/15",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"ingredients",
								"15"
							]
						}
					},
					"response": []
				},
				{
					"name": "DeleteIngredient/id",
					"request": {
						"method": "DELETE",
						"header": [],
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/ingredients/1",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"ingredients",
								"1"
							]
						}
					},
					"response": []
				},
				{
					"name": "EditIngredient/id",
					"request": {
						"method": "PATCH",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": "{\r\n  \"nom\": \"string\",\r\n  \"description\": \"string\",\r\n  \"prix\": \"string\",\r\n  \"categorieIngredients\": [\r\n    \"https://example.com/\"\r\n  ]\r\n}",
							"options": {
								"raw": {
									"language": "json"
								}
							}
						},
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/ingredients/1",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"ingredients",
								"1"
							]
						}
					},
					"response": []
				}
			]
		},
		{
			"name": "categoryIngredient",
			"item": [
				{
					"name": "GetAllCategoryIngredient",
					"request": {
						"method": "GET",
						"header": [],
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/categorie_ingredients",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"categorie_ingredients"
							]
						}
					},
					"response": []
				},
				{
					"name": "CreateCategoryIngredient",
					"request": {
						"auth": {
							"type": "bearer"
						},
						"method": "POST",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": "{\r\n  \"nom\": \"Argiles\",\r\n  \"ingredients\": [\r\n        \"http://localhost:8000/api/ingredients/17\",\r\n       \"http://localhost:8000/api/ingredients/18\",\r\n       \"http://localhost:8000/api/ingredients/19\",\r\n       \"http://localhost:8000/api/ingredients/20\",\r\n       \"http://localhost:8000/api/ingredients/21\"\r\n  ]\r\n}",
							"options": {
								"raw": {
									"language": "json"
								}
							}
						},
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/categorie_ingredients",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"categorie_ingredients"
							]
						}
					},
					"response": []
				},
				{
					"name": "GetCategoryIngredient/id",
					"request": {
						"method": "GET",
						"header": [],
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/categorie_ingredients/1",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"categorie_ingredients",
								"1"
							]
						}
					},
					"response": []
				},
				{
					"name": "DeleteCategoryIngredient/id",
					"request": {
						"auth": {
							"type": "bearer"
						},
						"method": "DELETE",
						"header": [],
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/categorie_ingredients/7",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"categorie_ingredients",
								"7"
							]
						}
					},
					"response": []
				},
				{
					"name": "EditCategoryIngredient/id",
					"request": {
						"auth": {
							"type": "bearer"
						},
						"method": "PATCH",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": "{\r\n  \"ingredients\": [\r\n       \"http://localhost:8000/api/ingredients/17\",\r\n       \"http://localhost:8000/api/ingredients/18\",\r\n       \"http://localhost:8000/api/ingredients/19\",\r\n       \"http://localhost:8000/api/ingredients/20\",\r\n       \"http://localhost:8000/api/ingredients/21\"\r\n  ]\r\n}",
							"options": {
								"raw": {
									"language": "json"
								}
							}
						},
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/categorie_ingredients/7",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"categorie_ingredients",
								"7"
							]
						}
					},
					"response": []
				}
			]
		},
		{
			"name": "categoryRecipe",
			"item": [
				{
					"name": "GetAllCategoryRecipe",
					"request": {
						"method": "GET",
						"header": [],
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/categorie_recettes",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"categorie_recettes"
							]
						}
					},
					"response": []
				},
				{
					"name": "CreateCategoryRecipe",
					"request": {
						"method": "POST",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": "{\r\n  \"nom\": \"Remèdes Naturels\",\r\n  \"recettes\": [\r\n  ]\r\n}",
							"options": {
								"raw": {
									"language": "json"
								}
							}
						},
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/categorie_recettes",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"categorie_recettes"
							]
						}
					},
					"response": []
				},
				{
					"name": "GetCategoryRecipe/id",
					"request": {
						"method": "GET",
						"header": [],
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/categorie_recettes/1",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"categorie_recettes",
								"1"
							]
						}
					},
					"response": []
				},
				{
					"name": "DeleteCategoryRecipe/id",
					"request": {
						"method": "DELETE",
						"header": [],
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/categorie_recettes/1",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"categorie_recettes",
								"1"
							]
						}
					},
					"response": []
				},
				{
					"name": "EditCategoryRecipe/id",
					"request": {
						"method": "PATCH",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": "{\r\n  \"nom\": \"string\",\r\n  \"ingredients\": [\r\n    \"https://example.com/\"\r\n  ]\r\n}",
							"options": {
								"raw": {
									"language": "json"
								}
							}
						},
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/categorie_recettes/1",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"categorie_recettes",
								"1"
							]
						}
					},
					"response": []
				}
			]
		},
		{
			"name": "QuantityIngredient",
			"item": [
				{
					"name": "GetAllQuantityIngredient",
					"request": {
						"method": "GET",
						"header": [],
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/quantite_ingredients",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"quantite_ingredients"
							]
						}
					},
					"response": []
				},
				{
					"name": "GetQuantityIngredient/idIngredient",
					"request": {
						"method": "GET",
						"header": [],
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/ingredients/1/quantite_ingredients",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"ingredients",
								"1",
								"quantite_ingredients"
							]
						}
					},
					"response": []
				},
				{
					"name": "CreateQuantityIngredient",
					"request": {
						"method": "POST",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": "{\r\n  \"quantite\": 350,\r\n  \"unite\": \"ml\",\r\n  \"idIngredient\": \"http://localhost:8000/api/ingredients/11\"\r\n}",
							"options": {
								"raw": {
									"language": "json"
								}
							}
						},
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/quantite_ingredients",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"quantite_ingredients"
							]
						}
					},
					"response": []
				},
				{
					"name": "DeleteQuantityIngredient",
					"request": {
						"method": "DELETE",
						"header": [],
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/quantite_ingredients/1",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"quantite_ingredients",
								"1"
							]
						}
					},
					"response": []
				},
				{
					"name": "GetQuantityIngredient/id",
					"request": {
						"method": "GET",
						"header": []
					},
					"response": []
				},
				{
					"name": "EditQuantityIngredient/id",
					"request": {
						"method": "PATCH",
						"header": [],
						"url": {
							"raw": "https://webinfo.iutmontp.univ-montp2.fr/~rathiers/projet_web/public/api/quantite_ingredients/1",
							"protocol": "https",
							"host": [
								"webinfo",
								"iutmontp",
								"univ-montp2",
								"fr"
							],
							"path": [
								"~rathiers",
								"projet_web",
								"public",
								"api",
								"quantite_ingredients",
								"1"
							]
						}
					},
					"response": []
				}
			]
		}
	],
	"auth": {
		"type": "bearer",
		"bearer": [
			{
				"key": "token",
				"value": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MDY1MjE2NTksImV4cCI6MTcwNjUyNTI1OSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoiYWRhbWF4IiwiaWQiOjEsImFkcmVzc2VNYWlsIjoiYWRhbWF4QGV4YW1wbGUuY29tIiwicHJlbWl1bSI6ZmFsc2V9.AsnRMW66S-sXL-YdbdKfnUv3_M-bM7p0DeNRIRcP6TCmrivXJf-URXmVrrbMtWMEkKSHDa6HAJrcNV5NdB8ZGSr5XpTlsJyXYcktEkdFtcj-AOYgyxlqyWo1Sq6MVxlEcNmd8YqbRDDLO2MmybQjrnDkOe5juMwpW8O9f_wG8hHYarIo3thcDoYwPp9JeaF8YzJuBw5e51sMlGSUgmQtVvTriVFgDzxsTxUYv-4rCMQclAASCkJAPfPqKf-2t50Y12qx4zBa3y94ColV0pLUMgXHP___o_C3hp96i9e0sypXptWfa76uBSSDaQQxEBnXoqMf2PGoWjJTCmT-Dttmkw",
				"type": "string"
			}
		]
	},
	"event": [
		{
			"listen": "prerequest",
			"script": {
				"type": "text/javascript",
				"exec": [
					""
				]
			}
		},
		{
			"listen": "test",
			"script": {
				"type": "text/javascript",
				"exec": [
					""
				]
			}
		}
	]
}
```
