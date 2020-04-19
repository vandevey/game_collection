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

        // ensure that resource have an extension before do the file research
        $resource .= isset(pathinfo($resource)['extension']) ? '' : '.' . self::EXTENSION;
        $resourcePath = self::FIXTURE_DIR . $resource; // get fixture file path

        return Yaml::parse(file_get_contents($resourcePath)); // return an array from yaml format
    }

    /**
     * Add fixture to the static list
     *
     * @warning use this method can affect fixtures list visibility,
     *          determined your need before using it.
     *
     * @param string $name
     */
    public function addFixtures(string $name)
    {
        self::$fixtures[] = $name;
        self::$fixtures = array_unique(self::$fixtures); // to ensure that data aren't duplicated
    }

    /**
     * @param $resource
     * @return bool
     */
    public function supports($resource)
    {
        return is_string($resource) && \in_array($resource, self::$fixtures);
    }
}