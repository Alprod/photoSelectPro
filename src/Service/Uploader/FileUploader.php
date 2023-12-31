<?php

namespace App\Service\Uploader;

use App\Logger\SecurityLogger;
use Random\RandomException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

readonly class FileUploader
{
    public function __construct(
        private string $targetDirectory,
        private SluggerInterface $slugger,
        private SecurityLogger $securityLogger,
        private UrlGeneratorInterface $urlGenerator
    )
    {
    }

    /**
     * @throws RandomException
     */
    public function upload(UploadedFile $file, string $prefix, string $route, array $params = []): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $bytes = random_bytes(4);
        $uniqId = bin2hex($bytes);
        $newFilemame = $safeFilename.'-'.$prefix.'_'.$uniqId.'.'.$file->guessExtension();
        try {
            $file->move($this->getTargetDirectory(), $newFilemame);
        }catch (FileException $f){
            $this->securityLogger->securityErrorLog('Erreur de deplacement du ficher', [
                'message' => $f->getMessage(),
                'class' => __CLASS__,
            ]);
            return new RedirectResponse($this->urlGenerator->generate($route, $params));
        }

        return $newFilemame;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }

}