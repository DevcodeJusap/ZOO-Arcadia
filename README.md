**Lisez-moi** 
===============

(Projet d'étude 2024) **Site Web du Zoo Arcadia**
------------------------

![Logo du Zoo Arcadia](image/presentation/logo.png)

### Présentation

Bienvenue sur le site web du Zoo Arcadia, 
un zoo fictif créé pour vous offrir une expérience unique et interactive.
Notre site web vous permet de découvrir les différents aspects du zoo, 
de ses animaux à ses habitats, en passant par les services offerts.

### Technologies Utilisées
-------------------------

Nous avons utilisé les technologies suivantes pour créer ce site web :

* **HTML5** pour structurer le contenu
* **CSS3** pour styliser et mettre en page
* **JavaScript** pour ajouter des fonctionnalités interactives
* **PHP** langage de programmation serveur
* **Bootstrap 4.5.2** pour créer une mise en page responsive
* **OwlCarousel2** pour créer des carrousels et des diaporamas
* **Font Awesome 5.15.1** pour ajouter des éléments visuels
* **MySQL** système de gestion de base de données relationnelles
* **phpMyAdmin** outil de gestion de base de données en ligne
* **WAMP** environnement de développement web
* **VS Code** éditeur de code source

### Fonctionnalités
--------------

### Frontend

* **Page d'Accueil** : découvrez le zoo et ses activités
* **Page Services** : découvrez les services offerts par le zoo
* **Page Habitats** : découvrez les différents habitats du zoo
* **Page Animaux** : explorez les différentes espèces d'animaux
* **Page Contact** : contactez-nous pour en savoir plus
* **Page Avis** : donner votre avis
* **Page Login** : Connexion administrateur et employés 

### Backend

* **Gestion des Utilisateurs** : gérer les comptes utilisateurs et les autorisations
* **Gestion des Animaux** : gérer les informations sur les animaux
* **Gestion des Habitats** : gérer les informations sur les habitats
* **Gestion des Services** : gérer les informations sur les services
* **API** : récupérer et manipuler les données de la base de données

### Installation
--------------

**Étape 1 : Télécharger et extraire le projet**
- Allez sur le répertoire GitHub du projet Zoo-Arcadia et cliquez sur le bouton "Code".
- Cliquez sur "Télécharger ZIP" pour télécharger le projet sous forme de fichier ZIP.
- Extraire le fichier ZIP dans un répertoire de votre machine locale.

**Étape 2 : Importer le schéma de base de données**
- Ouvrez votre outil de gestion de base de données MySQL, comme phpMyAdmin.
- Créez une nouvelle base de données pour le projet Zoo-Arcadia.
- Importez le schéma de base de données en exécutant le script SQL situé dans le répertoire database du projet.
- Le script SQL créera les tables et les relations nécessaires pour le projet.
  
**Étape 3 : Configurer la connexion à la base de données**
- Ouvrez le fichier db_config.php situé dans le répertoire includes du projet.
- Mettez à jour les paramètres de connexion à la base de données pour correspondre à votre environnement local :
- DB_HOST : le nom d'hôte de votre serveur MySQL
- DB_USERNAME : le nom d'utilisateur à utiliser pour la connexion à la base de données
- DB_PASSWORD : le mot de passe à utiliser pour la connexion à la base de données
- DB_NAME : le nom de la base de données à utiliser pour le projet
- Enregistrez les modifications apportées au fichier db_config.php.

**Étape 4 : Ouvrir le projet dans VS Code et exécuter le fichier d'index**
Ouvrez le répertoire du projet dans VS Code.
Ouvrez le fichier index.php situé à la racine du projet.
Cliquez sur le bouton "Exécuter" ou appuyez sur F5 pour exécuter le fichier index.php.

Le projet devrait maintenant être en cours d'exécution sur votre machine locale, 
et vous pouvez y accéder en naviguant vers http://localhost/zoo-arcadia dans votre navigateur web.

**Note** : Assurez-vous d'avoir un serveur PHP installé et configuré sur votre machine locale, comme **XAMPP ou WAMP**, pour exécuter le projet.

### Configuration
--------------

* **Base de Données** : configurer les paramètres de connexion à la base de données
* **Serveur** : configurer les paramètres du serveur

### Dépendances
--------------

* **Bootstrap** : dépendance pour la mise en page responsive
* **OwlCarousel2** : dépendance pour les carrousels et les diaporamas
* **Font Awesome** : dépendance pour les éléments visuels
* **PHPMailer** : dépendance pour envoyer des e-mails

### Auteurs
---------

* [Julien Le Nir "DevcodeJusap" : devcodejusap@gmail.com ou www.c@delinky.com]

---------

Ce projet est en openSource.

### Remerciements
--------------

* Merci à pour leurs bibliothèques et frameworks open-source.
* Merci à WAMP et VS Code pour leurs environnements de développement. 

### Problèmes et Améliorations
-----------------------------

Si vous rencontrez des problèmes ou avez des suggestions d'amélioration, veuillez ouvrir un ticket sur le dépôt GitHub.

### Contribuer
------------

Si vous souhaitez contribuer à ce projet, veuillez consulter me contacter pour obtenir des informations sur la façon de contribuer.

### Historique des Mises à Jour
-----------------------------

* **Version 1.0** : première version du site web
* **Version 1.1** : ajout de la gestion des animaux
* **Version 1.2** : ajout de la gestion des habitats
* **Version 1.3** : ajout de la gestion des services
