<?php


namespace App\DataFixtures;


use App\Entity\ItemAd;
use App\Entity\Request;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AdsFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    /** @var string */
    public const RESOURCE_NAME = 'ads';
    /** @var string */
    protected $resourceName = self::RESOURCE_NAME;

    /**
     * @inheritDoc
     */
    function load(ObjectManager $manager)
    {
        $ads = $this->fixtureLoader->load(self::RESOURCE_NAME);
        foreach ($ads['data'] as $ref => $adData) {
            /** @var ItemAd $itemAd */
            $itemAd = $this->denormilazer->denormalize($adData, ItemAd::class);

            // if fixture is a request
            if (isset($adData['ref']['request'])) {
                $request = $this->denormilazer->denormalize($adData['ref']['request'], Request::class);
                $itemAd->setRequest($request);

                $manager->persist($request);
            }

            $itemAd->setCreatedAt();
            $itemAd->setUpdatedAt();

            $manager->persist($itemAd);
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            ItemsFixtures::class,
        ];
    }
}