<?php


namespace App\DataFixtures;


use App\Entity\Item;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ItemsFixtures extends AbstractFixtures implements DependentFixtureInterface
{

    /**
     * File fixture name
     *
     * @var string
     */
    const RESOURCE_NAME = 'items';

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $items = $this->fixtureLoader->load(self::RESOURCE_NAME);

        foreach ($items['data'] as $itemData) {
            /** @var Item $item */
            $item = $this->denormilazer->denormalize($itemData, Item::class);
            $item->setAuthor(
                $this->getReference($itemData['ref']['author'])
            );

            foreach ($itemData['ref']['categories'] as $category) {
                $item->addCategory(
                    $this->getReference($category)
                );
            }

            $item->setCreatedAt();
            $item->setUpdatedAt();

            $manager->persist($item);
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            CategoriesFixtures::class,
            UserFixtures::class
        ];
    }
}