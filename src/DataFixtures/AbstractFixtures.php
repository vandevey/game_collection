<?php


namespace App\DataFixtures;


use App\Services\FixtureLoader;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

abstract class AbstractFixtures extends Fixture
{

    /** @var FixtureLoader */
    protected $fixtureLoader;
    /** @var DenormalizerInterface */
    protected $denormilazer;

    public function __construct(FixtureLoader $fixtureLoader, DenormalizerInterface $denormalizer)
    {
        $this->fixtureLoader = $fixtureLoader;
        $this->denormilazer = $denormalizer;

//        $this->setReferenceAlias();
    }

    /**
     * @inheritDoc
     */
    abstract function load(ObjectManager $manager);
}