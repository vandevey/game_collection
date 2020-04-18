<?php


namespace App\DataFixtures;


use App\Entity\Item;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ItemsFixtures extends AbstractFixtures implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $items = $this->fixtureLoader->load('items');

        foreach ($items['data'] as $itemData) {
            /** @var Item $item */
            $item = $this->denormilazer->denormalize($itemData, Item::class);
            $item->setAuthor($this->getReference($itemData['ref']['author']));

            foreach ($itemData['ref']['categories'] as $category) {
                $item->addCategory($this->getReference($category));
            }

            dd($item);
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