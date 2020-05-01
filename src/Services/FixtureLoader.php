<?php


namespace App\Services;

use Symfony\Component\Yaml\Yaml;

/**
 * Class FixtureLoader
 *
 * @package App\Services
 */
class FixtureLoader
{
    private const FIXTURE_DIR = __DIR__ . '/../DataFixtures/Fixtures/';
    private const EXTENSION = 'yaml';


    /**
     * @param string $resource
     * @return mixed|null
     */
    public function load(string $resource)
    {
        // ensure that resource have an extension before do the file research
        $resource .= isset(pathinfo($resource)['extension']) ? '' : '.' . self::EXTENSION;
        $resourcePath = self::FIXTURE_DIR . $resource; // get fixture file path

        if (!$this->supports($resourcePath)) {
            return null;
        }

        return Yaml::parse(file_get_contents($resourcePath)); // return an array from yaml format
    }

    /**
     * Check if fixture resource is supported
     *  > file exist
     *  > extension is supported by class
     *
     * @param $resource
     * @return bool
     */
    public function supports($resource)
    {
        return is_string($resource)
            && file_exists($resource)
            && self::EXTENSION === pathinfo($resource, PATHINFO_EXTENSION);
    }
}