<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i=0; $i <=10 ; $i++) {
            $product = new Product();
            $product->setLib("lib $i")
            ->setPrixUnitaire($i*10+5)
            ->setDecription("description de l'article n° $i")
            ->setImage("http://placehold.it/350*150");
            $manager->persist($product);
            }
            
            

        $manager->flush();
    }
}
