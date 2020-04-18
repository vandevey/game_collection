<?php


namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;


class CategoriesFixtures extends AbstractFixtures
{
    protected $referenceKey = 'categories';

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $categories = $this->fixtureLoader->load('categories');

        foreach ($categories['data'] as $ref => $categoryData) {
            $category = $this->denormilazer->denormalize($categoryData, Category::class);
            $manager->persist($category);

            $this->addReference($ref, $category);
        }

        $manager->flush();
    }
}