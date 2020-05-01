<?php


namespace App\DataFixtures;


use App\Services\FixtureLoader;
use App\Services\GameApi;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

abstract class AbstractFixtures extends Fixture
{
    /** @var array */
    private static $TEMP_DATA = [];
    protected $resourceName;

    /** @var FixtureLoader */
    protected $fixtureLoader;
    /** @var DenormalizerInterface */
    protected $denormilazer;
    /** @var GameApi */
    protected $gameApi;

    public function __construct(FixtureLoader $fixtureLoader, DenormalizerInterface $denormalizer, GameApi $gameApi)
    {
        $this->fixtureLoader = $fixtureLoader;
        $this->denormilazer = $denormalizer;
        $this->gameApi = $gameApi;
    }

    /**
     * @inheritDoc
     */
    abstract function load(ObjectManager $manager);

    public function addTempData(string $entity, $data)
    {
        self::$TEMP_DATA[$entity][] = $data;
    }

    public function getTempData(string $entity)
    {
        return self::$TEMP_DATA[$entity];
    }

    /**
     * @param $key
     * @param string|null $resource
     * @return string
     */
    protected function buildReferenceName($key, string $resource = null)
    {
        if (\is_array($key)) {
            $key = implode('.', $key);
        }

        $resource = $resource ?? $this->resourceName;
        return sprintf('%s.%s', $resource, $key);
    }
}