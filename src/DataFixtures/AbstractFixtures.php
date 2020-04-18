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

    /** @var string */
    protected $referenceKey = '';

//    public static $REFERENCES = [];

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

//    public function addReference($name, $object)
//    {
//        self::$REFERENCES[$this->referenceKey][] = $name;
//
//        parent::addReference($name, $object);
//    }
//
//    public function getReference($name)
//    {
//        dd($this->referenceRepository->getReferences());
//    }

    // #### ReferenceAliasFixtureInterface Support #### //

//    /**
//     * Get alias wrapper to ensure that class implement ReferenceAliasFixtureInterface interface
//     *
//     * @return array
//     */
//    public function getReferenceAliases(): array
//    {
//        if (
//        \in_array(
//            ReferenceAliasFixtureInterface::class,
//            class_implements($this)
//        )
//        ) {
//            return $this->getReferenceAlias();
//        }
//
//        return [];
//    }
//
//    private function setReferenceAlias()
//    {
//        $alias = $this->getReferenceAliases();
//        foreach ($alias as $name) {
//            self::$REFERENCES[$name] = $this->referenceKey;
//        }
//    }
}