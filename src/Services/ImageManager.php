<?php


namespace App\Services;


use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Mime\MimeTypes;
use Symfony\Component\Mime\MimeTypesInterface;

class ImageManager
{
    public const IMAGE_DIR = 'assets/images';

    /** @var Filesystem */
    private $fileSystem;
    /** @var string */
    private $rootDir;
    /** @var MimeTypesInterface */
    private $mimeTypes;

    public function __construct(Filesystem $filesystem, KernelInterface $kernel)
    {
        $this->fileSystem = $filesystem;
        $this->rootDir = $kernel->getProjectDir();
        $this->mimeTypes = new MimeTypes(); // can't autowire then launch new instance
    }

    /**
     * @param string $url
     * @param int $id
     * @param string $dir
     *
     * @return bool|string
     *
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function download(string $url, int $id, string $dir = '')
    {
        try {
            $client = HttpClient::create();
            $response = $client->request('GET', 'https:' . $url);

            $imageData = $response->getContent();
            $ext = $this->mimeTypes->getExtensions($response->getInfo('content_type'));
            $imagePath = sprintf('%s/%s/%s/%s.%s', $this->rootDir, self::IMAGE_DIR, $dir, $id, $ext[0]);
            $this->fileSystem->dumpFile($imagePath, $imageData);

            return basename($imagePath);
        } catch (\Exception $e) {
        }

        return false;
    }
}