<?php


namespace App\DataFixtures;


use App\Entity\Image;
use App\Entity\Item;
use App\Services\FixtureLoader;
use App\Services\GameApi;
use App\Services\ImageManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ImagesFixture extends AbstractFixtures implements DependentFixtureInterface
{

    /** @var ImageManager */
    private $imageManager;

    public function __construct(ImageManager $imageManager,
                                FixtureLoader $fixtureLoader,
                                DenormalizerInterface $denormalizer,
                                GameApi $gameApi
    )
    {
        $this->imageManager = $imageManager;
        parent::__construct($fixtureLoader, $denormalizer, $gameApi);
    }

    /**
     * @inheritDoc
     */
    function load(ObjectManager $manager)
    {
        $tempItems = $this->getTempData(Item::class);
        foreach ($tempItems as $tempItem) {
            if (!($imageName = $this->imageManager->downloadFromUrl($tempItem['url'], $tempItem['refId'], 'items'))) {
                continue;
            }
            $image = new Image();
            $image->setItem(
                $this->getReference(
                    $this->buildReferenceName($tempItem['refId'], ItemsFixtures::RESOURCE_NAME)
                )
            );
            $image->setPath($imageName);

            $manager->persist($image);
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