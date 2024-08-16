<?php

namespace App\DataFixtures;

use App\Factory\AuthorFactory;
use App\Factory\BookFactory;
use App\Factory\EditorFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création des éditeurs
        EditorFactory::createMany(5);

        // Création des auteurs
        AuthorFactory::createMany(20);

        // Création des utilisateurs
        UserFactory::createMany(5);

        // Création de commentaires sous les livres
        UserFactory::createMany(2);

        // Création des livres avec une image aléatoire pour chaque livre
        BookFactory::createMany(100, function() {
            return [
                'cover' => 'https://picsum.photos/200/300', // URL pour une image aléatoire de Picsum
            ];
        });

        $manager->flush();
    }
}
