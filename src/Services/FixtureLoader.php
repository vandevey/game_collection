<?php


namespace App\Services;

use Symfony\Component\Yaml\Yaml;

class FixtureLoader
{
    private const FIXTURE_DIR = __DIR__ . '/../DataFixtures/Fixtures/';
    private const EXTENSION = 'yaml';
    /** @var array */
    static $fixtures = [
        'categories',
        'users',
        'items',
        'offer',
        'request',
    ];

    /**
     * @param string $resource
     * @return mixed|null
     */
    public function load(string $resource)
    {
        if (!$this->supports($resource)) {
            return null;
        }

        $resource .= isset($resource['extension']) ? '' : '.' . self::EXTENSION;
        $resourcePath = self::FIXTURE_DIR . $resource;

        return Yaml::parse(file_get_contents($resourcePath));
    }

    /**
     * @param $resource
     * @param string|null $type
     * @return bool
     */
    public function supports($resource, string $type = null)
    {
        return is_string($resource) && \in_array($resource, self::$fixtures);
    }
}