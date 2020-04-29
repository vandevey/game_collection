<?php


namespace App\Services;


use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
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
    public function download(string $url, int $id, string $dir = null): string
    {
        try {
            $client = HttpClient::create();
            $response = $client->request('GET', 'https:' . $url);

            $imageData = $response->getContent();
            $ext = $this->mimeTypes->getExtensions($response->getInfo('content_type'));
            $imagePath = $this->getPath($id, $ext[0], $dir, true);
            $this->fileSystem->dumpFile($imagePath, $imageData);

            return basename($imagePath);
        } catch (\Exception $e) {
        }

        return false;
    }

    public function exists(string $key, string $dir = null, string $extension = null)
    {
        $finder = new Finder();
        $finder->in($this->rootDir . '/' . self::IMAGE_DIR);
        if (null !== $dir) {
            $finder->in($dir);
        }

        $path = $key . (null !== $extension ? '.' . $extension : '');
        return $finder->path($path)->count();
    }

    public function getPath($id, $ext = null, $dir = null, bool $new = false)
    {
        if ($new) {
            if (empty($ext)) {
                throw new \RuntimeException(
                    'File extension must be defined for new image. Provident image key : ' . $id
                );
            }
            $dir = null !== $dir ? '/' . $dir : '';
            return sprintf('%s/%s%s/%s.%s', $this->rootDir, SELF::IMAGE_DIR, $dir, $id, $ext);
        } else {
            $finder = new Finder();
            $finder->in($this->rootDir . '/' . self::IMAGE_DIR);
            if (null !== $dir) {
                $finder->in($dir);
            }

            $path = $id . (null !== $ext ? '.' . $ext : '');
            return $finder->path($path);
        }

    }
}