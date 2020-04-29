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
    protected $resourceName = self::RESOURCE_NAME;

    public const GENRES_REF = 'genres';
    public const DEFAULT_REF = 'default';


    public const PLATEFORM_CATEGORY_MAPPING = [
        1 => 'console',
        2 => 'arcade',
        3 => 'platform',
        4 => 'operating_system',
        5 => 'portable_console',
        6 => 'computer',
    ];

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        // root categories
        $rootCategories = $this->fixtureLoader->load(self::RESOURCE_NAME);
        foreach ($rootCategories['data'] as $ref => $rootCategoryData) {
            /** @var Category $category */
            $category = $this->denormilazer->denormalize($rootCategoryData, Category::class);
            $manager->persist($category);
            $this->addReference($this->buildReferenceName($ref), $category);

            // c'est crade je sais, mais pas le temps
            if (isset($rootCategoryData['child'])) {
                foreach ($rootCategoryData['child'] as $ref => $childrenData) {
                    /** @var Category $category */
                    $category = $this->denormilazer->denormalize($childrenData, Category::class);
                    $manager->persist($category);
                    $this->addReference($this->buildReferenceName($ref), $category);
                }
            }
        }
        // root categories

        // genres
        $categories = $this->gameApi->getGenres();
        foreach ($categories as $categoryData) {
            /** @var Category $category */
            $category = $this->denormilazer->denormalize($categoryData, Category::class);
            $category->setParent(
                $this->getReference($this->buildReferenceName(self::GENRES_REF))
            );
            $manager->persist($category);

            $this->addReference($this->buildReferenceName([self::GENRES_REF, $categoryData->id]), $category);
        }
        // genres

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