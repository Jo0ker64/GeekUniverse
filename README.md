
# GeekUniverse - Gestion de Médiathèque

## Description

GeekUniverse est une application web développée en Symfony, conçue pour gérer efficacement une médiathèque. L'application permet aux administrateurs de gérer les livres, les auteurs, et les éditeurs à travers une interface conviviale, tout en offrant une expérience de consultation fluide et agréable pour les utilisateurs finaux.

## Fonctionnalités

### Pour les Administrateurs :
- **Gestion des Livres** : Ajouter, éditer, supprimer et consulter les livres dans la base de données.
- **Gestion des Auteurs** : Ajouter, éditer, supprimer et consulter les informations des auteurs.
- **Gestion des Éditeurs** : Ajouter, éditer, supprimer et consulter les éditeurs.
- **Tableau de Bord** : Interface centralisée pour accéder rapidement aux différentes sections de gestion.

### Pour les Utilisateurs :
- **Catalogue des Livres** : Parcourir un catalogue complet de livres avec des informations détaillées sur chaque ouvrage.
- **Détails des Livres** : Consulter les détails d'un livre spécifique, y compris les informations sur les auteurs et l'éditeur.
- **Recherche et Navigation** : Accéder facilement aux informations souhaitées grâce à une navigation intuitive.

## Prérequis

- **PHP 8.1+**
- **Composer**
- **Symfony CLI**
- **Base de données MySQL ou autre** (configurable dans `.env`)

## Installation

1. **Cloner le dépôt :**

   ```bash
   git clone https://github.com/Jo0ker64/GeekUniverse.git
   ```

2. **Installer les dépendances :**

   ```bash
   cd geekuniverse
   composer install
   ```

3. **Configurer l'environnement :**

   Copier le fichier `.env` et ajuster les paramètres (base de données, mailer, etc.) :

   ```bash
   cp .env .env.local
   ```

4. **Configurer la base de données :**

   Créer la base de données et exécuter les migrations :

   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

5. **Lancer le serveur de développement :**

   ```bash
   symfony server:start
   ```

   L'application sera accessible à l'adresse `http://localhost:8000`.

## Tests

Les tests unitaires sont écrits avec PHPUnit et se trouvent dans le répertoire `tests/`. Pour exécuter les tests :

```bash
php bin/phpunit
```

## Contribuer

Les contributions sont les bienvenues ! Si vous souhaitez ajouter des fonctionnalités, corriger des bugs ou améliorer la documentation, veuillez soumettre une pull request.

## Licence

Ce projet est sous licence MIT. Veuillez consulter le fichier `LICENSE` pour plus d'informations.

---

Ce README fournit une vue d'ensemble complète du projet, des instructions d'installation, et des informations utiles pour les utilisateurs et les contributeurs potentiels. Tu peux l'adapter en fonction des spécificités de ton projet.




Certainly! Here’s the README translated into English:

---

# GeekUniverse - Media Library Management

## Description

GeekUniverse is a web application developed with Symfony, designed to efficiently manage an media library. The application allows administrators to manage books, authors, and publishers through a user-friendly interface, while providing a smooth and pleasant browsing experience for end-users.

## Features

### For Administrators:
- **Book Management**: Add, edit, delete, and view books in the database.
- **Author Management**: Add, edit, delete, and view author information.
- **Publisher Management**: Add, edit, delete, and view publishers.
- **Dashboard**: Centralized interface to quickly access different management sections.

### For Users:
- **Book Catalog**: Browse a complete catalog of books with detailed information on each title.
- **Book Details**: View detailed information about a specific book, including author and publisher details.
- **Search and Navigation**: Easily access the desired information through intuitive navigation.

## Requirements

- **PHP 8.1+**
- **Composer**
- **Symfony CLI**
- **MySQL or other database** (configurable in `.env`)

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/your-username/geekuniverse.git
   ```

2. **Install dependencies:**

   ```bash
   cd geekuniverse
   composer install
   ```

3. **Configure the environment:**

   Copy the `.env` file and adjust the settings (database, mailer, etc.):

   ```bash
   cp .env .env.local
   ```

4. **Set up the database:**

   Create the database and run the migrations:

   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

5. **Start the development server:**

   ```bash
   symfony server:start
   ```

   The application will be accessible at `http://localhost:8000`.

## Testing

Unit tests are written using PHPUnit and can be found in the `tests/` directory. To run the tests:

```bash
php bin/phpunit
```

## Contributing

Contributions are welcome! If you want to add features, fix bugs, or improve the documentation, please submit a pull request.

## License

This project is licensed under the MIT License. Please see the `LICENSE` file for more information.

---

This English version of the README provides the same comprehensive overview of the project, installation instructions, and other useful information for users and contributors. Feel free to modify it according to the specific details of your project.