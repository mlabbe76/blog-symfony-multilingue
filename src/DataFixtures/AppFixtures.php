<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Faker\Factory::create();
        // Nous initialisation les donnees Faker afin de pouvoir lancer la boucle de creation de 50 Users via les Fixtures
        $users = [];

        for ($i=0; $i < 50; $i++){
            $user = new User();
            $user->setUsername($faker->name);
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setEmail($faker->email);
            $user->setPassword($faker->password());
            $user->setCreatedAt(new \DateTime());
            $manager->persist($user);
            $users[] = $user;
        }

        $categories = [];

        for ($i=0; $i < 15; $i++){
            $category = new Category();
            $category->setTitle($faker->text(50));
            $category->setDescription($faker->text(50));
            $category->setImage($faker->picsumUrl());
            $manager->persist($category);
            $categories[] = $category;

        }

        for ($i=0; $i < 100; $i++){
            $article = new Article();
            $article->setTitle($faker->text(50));
            $article->setContent($faker->text(6000));
            $article->setImage($faker->picsumUrl());
            $article->setCreatedAt(new \DateTime());
            $article->addCategory($categories[$faker->numberBetween(0,14)]);
            // Nous ajoutons les categories créées auparavant de 1 a 15 (Pour celà nous allons utiliser numberbetween)
            $article->setAuthor($users[$faker->numberBetween(0,49)]);
            $manager->persist($article);

        }

        $manager->flush();
    }
}
