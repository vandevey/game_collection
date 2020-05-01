<?php


namespace App\Services;


use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Mime\MimeTypes;
use Symfony\Component\Mime\MimeTypesInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageManager
{
    public const IMAGE_DIR = 'assets/images';
    public const PUBLIC_IMAGE_DIR = 'public/build/images';

    /** @var Filesystem */
    private $fileSystem;
    /** @var string */
    private $rootDir;
    /** @var MimeTypesInterface */
    private $mimeTypes;
    /** @var SluggerInterface */
    private $slugger;

    public function __construct(Filesystem $filesystem, KernelInterface $kernel, SluggerInterface $slugger)
    {
        $this->fileSystem = $filesystem;
        $this->rootDir = $kernel->getProjectDir();
        $this->slugger = $slugger;
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
    public function downloadFromUrl(string $url, int $id, string $dir = null): string
    {
        try {
            $client = HttpClient::create();
            $response = $client->request('GET', 'https:' . $url);

            $imageData = $response->getContent();
            $ext = $this->mimeTypes->getExtensions($response->getInfo('content_type'));
            $imagePath = $this->getPath($this->getFilename($id, $ext[0]), $dir, true);
            $this->fileSystem->dumpFile($imagePath, $imageData);

            $this->moveToBuildFile($imagePath, $dir);
            return basename($imagePath);
        } catch (\Exception $e) {
        }

        return false;
    }

    /**
     * @param File $file
     * @param string|null $dir
     * @return string
     */
    public function download(?File $file, string $dir = null): string
    {
        if ($file) {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $newFilename = $this->getFilename($safeFilename.'-'.uniqid(), $file->guessExtension());
            try {
                $fullDir = $this->getDir($dir);
                $file->move(
                    $fullDir,
                    $newFilename
                );

                $this->moveToBuildFile($fullDir .'/'. $newFilename, $dir);
                return $newFilename;
            } catch (FileException $e) {}
        }

        return false;
    }

    private function moveToBuildFile(string $path, string $dir = null)
    {
        try {
            $this->fileSystem->copy(
                $path,
                $this->getDir($dir, SELF::PUBLIC_IMAGE_DIR) . '/' . basename($path)
            );
        } catch (FileNotFoundException $e) {}
    }
    
    public function getPath(string $filename, $dir = null, bool $new = false): string
    {
        if ($new) {
            return sprintf('%s/%s', $this->getDir($dir), $filename);
        } else {
            $finder = new Finder();
            $finder->in($this->getDir($dir));
            return $finder->path($filename);
        }

    }

    public function getFilename(string $name, string $extension): string
    {
        return sprintf('%s.%s', $name, $extension);
    }

    public function getDir(string $dir = null, string $resourceDir = SELF::IMAGE_DIR): string
    {
        $dir = null !== $dir ? '/' . $dir : '';
        return sprintf('%s/%s%s', $this->rootDir, $resourceDir, $dir);
    }
}