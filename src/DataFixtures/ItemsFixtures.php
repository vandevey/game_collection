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
    public const PLATFORMS_REF = 'platforms';
    public const GAMES_REF = 'games';
    protected $resourceName = self::RESOURCE_NAME;

    public static $TOTAL_ITEMS = 0;

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $items = [
            self::GAMES_REF => $this->gameApi->getGames(),
            self::PLATFORMS_REF => $this->gameApi->getPlateforms(),
        ];

        foreach ($items as $itemsType) {
            foreach ($itemsType as $ref => $itemData) {
                if (!isset($itemData->summary)) {
                    continue;
                }
                /** @var Item $item */
                $item = new Item();
                $item->setName($itemData->name);
                $item->setDescription($itemData->summary);
                $item->setAuthor(
                    $this->getReference($this->buildReferenceName(rand(1, 2), UserFixtures::RESOURCE_NAME))
                );

                if (isset($itemData->genres)) {
                    foreach ($itemData->genres as $categoryId) {
                        try {
                            $item->addCategory(
                                $this->getReference(
                                    $this->buildReferenceName($categoryId, CategoriesFixtures::RESOURCE_NAME)
                                )
                            );
                        } catch (\Exception $e) {
                        }
                    }
                } else if (isset($itemData->category)) {
                    try {
                        $refCat = CategoriesFixtures::PLATEFORM_CATEGORY_MAPPING[$itemData->category];
                        $item->addCategory(
                            $this->getReference(
                                $this->buildReferenceName($refCat, CategoriesFixtures::RESOURCE_NAME)
                            )
                        );
                    } catch (\Exception $e) {
                    }
                } else {
                    $item->addCategory(
                        $this->getReference(
                            $this->buildReferenceName(
                                CategoriesFixtures::DEFAULT_REF,
                                CategoriesFixtures::RESOURCE_NAME
                            )
                        )
                    );
                }

                $item->setCreatedAt();
                $item->setUpdatedAt();

                $manager->persist($item);

                if (isset($itemData->cover)) {
                    $coverUrl = $this->gameApi->getCover($itemData->cover);
                    $this->addTempData(
                        Item::class,
                        ['refId' => $ref . '.' . $itemData->id, 'url' => $coverUrl[0]->url]
                    );
                } else if (isset($itemData->platform_logo)) {
                    $coverUrl = $this->gameApi->getPlateformLogo($itemData->platform_logo);
                    $this->addTempData(
                        Item::class,
                        ['refId' => $ref . '.' . $itemData->id, 'url' => $coverUrl[0]->url]
                    );
                }

                self::$TOTAL_ITEMS += 1;
                $this->addReference($this->buildReferenceName([$ref, $itemData->id]), $item);
            }
        }
        unset($itemsType, $itemData, $items);

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