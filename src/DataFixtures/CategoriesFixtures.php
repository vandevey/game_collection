<?php


namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;


class CategoriesFixtures extends AbstractFixtures
{
    /**
     * File fixture name
     *
     * @var string
     */
    public const RESOURCE_NAME = 'categories';

    public const DEFAULT_CATEGORY = 'cat_default';

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        // default category if no genre from API
        $defaultCategory = new Category();
        $defaultCategory->setName('default');
        $manager->persist($defaultCategory);
        $this->addReference(self::DEFAULT_CATEGORY, $defaultCategory);

        $categories = $this->gameApi->getGenres();

        foreach ($categories as $categoryData) {
            /** @var Category $category */
            $category = $this->denormilazer->denormalize($categoryData, Category::class);
            $manager->persist($category);

            $this->addReference(self::RESOURCE_NAME . $categoryData->id, $category);
        }

        $manager->flush();
    }

    private function getFromYaml(ObjectManager $manager)
    {
        $categories = $this->fixtureLoader->load(self::RESOURCE_NAME);

        foreach ($categories['data'] as $ref => $categoryData) {
            $category = $this->denormilazer->denormalize($categoryData, Category::class);
            $manager->persist($category);

            $this->addReference($ref, $category);
        }

        $manager->flush();
    }
}