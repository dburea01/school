# A propos de SCHOOL

SCHOOL est un outil de gestion d'établissement scolaire, simple, destiné aux écoles ne pouvant pas investir dans un des nombreux systèmes du marché.

SCHOOL est un logicial open source. Vous êtes libre de l'installer, l'utiliser à votre convenance. Et de le modifier également à votre convenance. Les sources sont sur [https://github.com/dburea01/school](https://github.com/dburea01/school).

SCHOOL est majoritairement destiné à la gestion d'une école dont les fonctionnalités se rapprochent d'une école française. SCHOOL est en français. 

Une démonstration est disponible ici : [github](https://github.com/dburea01/school).

## 🤝 Contribution & Recherche de Product Owner (PO)

Je suis actuellement à la recherche d'un **Product Owner (PO) motivé** pour m'accompagner et me guider dans les prochaines étapes de développement du projet (définition de la roadmap, cadrage des fonctionnalités, rédaction des user stories, priorisation du backlog, testing...).

Si le projet vous intéresse et que vous souhaitez collaborer, n'hésitez pas à me contacter !

## 📋 Prérequis

Avant de commencer, vérifiez que votre environnement de développement dispose des outils suivants :

* **Git**
* **PHP** (>= 8.3)
* **Composer** (Gestionnaire de dépendances PHP)
* **Node.js** & **npm** (Gestionnaire de dépendances JS)
* **SGBD / Base de données** : PostgreSQL (non testé sur d'autres SGBD)

---

## 🛠️ Étapes d'installation

### 1 : Cloner le projet Git

Récupérez le dépôt distant et ouvrez le dossier du projet dans votre terminal :

```bash
git clone https://github.com/dburea01/school.git
cd nom-du-projet
```

---

### 2 : Installer les dépendances PHP

Installez l'ensemble des paquets requis définis dans `composer.json` :

```bash
composer install
```

---

### 3 : Installer et compiler les dépendances Frontend

Installez les dépendances JavaScript et démarrez le serveur de build (Vite / Mix) :

```bash
npm install
npm run dev
```

---

### 4 : Dupliquer le fichier de configuration `.env`

Créez votre propre fichier d'environnement local à partir du modèle fourni :

```bash
cp .env.example .env
```

---

### 5 : Configurer la base de données

Ouvrez le fichier `.env` avec votre éditeur de code et adaptez les paramètres d'accès à votre base de données :

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nom_de_votre_bdd
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

> **Note :** Pensez à créer la base de données (`nom_de_votre_bdd`) dans votre gestionnaire de BDD (DBeaver par example) avant de passer à l'étape suivante.

---

### 6 : Générer la clé d'application

Générez la clé d'encodage unique `APP_KEY` dans votre fichier `.env` :

```bash
php artisan key:generate
```

---

### 7 : Exécuter les migrations et alimenter la BDD

Créez les tables :

```bash
php artisan migrate
```

Vous pouvez également créer les tables et les alimenter avec un jeu de données fictif :

```bash
php artisan migrate --seed
```

---

### 8 : Créer le lien symbolique pour le stockage

Pour le stockage en local des images :

```bash
php artisan storage:link
```

---

### 9 : Lancer le serveur de développement

Démarrez le serveur local Laravel :

```bash
php artisan serve
```

L'application est désormais accessible à l'adresse suivante : **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 💡 Commandes utiles au quotidien

* **Vider les caches (configuration, routes, vues) :**

  ```bash
  php artisan optimize:clear
  ```

* **Réinitialiser complètement la base de données avec les seeders :**

  ```bash
  php artisan migrate:fresh --seed
  ```

* **Lister toutes les routes de l'application :**

  ```bash
  php artisan route:list
  ```