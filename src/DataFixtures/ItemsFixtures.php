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
        $items = $this->gameApi->getGames();

        foreach ($items as $itemData) {
            /** @var Item $item */
            $item = $this->denormilazer->denormalize($itemData, Item::class);
            if (!isset($itemData->summary)) {
                continue;
            }

            $item->setDescription($itemData->summary);
            $item->setAuthor(
                $this->getReference(UserFixtures::RESOURCE_NAME . rand(1, 2))
            );

            if (isset($itemData->genres)) {
                foreach ($itemData->genres as $categoryId) {
                    try {
                        $item->addCategory(
                            $this->getReference(CategoriesFixtures::RESOURCE_NAME . $categoryId)
                        );
                    } catch (\Exception $e) {
                    }
                }
            } else {
                $item->addCategory($this->getReference(CategoriesFixtures::DEFAULT_CATEGORY));
            }

            $item->setCreatedAt();
            $item->setUpdatedAt();

            $manager->persist($item);
            if (isset($itemData->cover)) {
                $coverUrl = $this->gameApi->getCover($itemData->cover);
                $this->addTempData(Item::class, ['refId' => $itemData->id, 'url' => $coverUrl[0]->url]);
            }

            $this->addReference(self::RESOURCE_NAME . $itemData->id, $item);
        }

        $manager->flush();
    }

    private function getFromYaml(ObjectManager $manager)
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