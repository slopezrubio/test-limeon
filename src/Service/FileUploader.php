<?php


namespace App\Service;

use Doctrine\ORM\Tools\DebugUnitOfWorkListener;
use Symfony\Component\HttpFoundation\File\Exeption\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDirectory;

    public function __construct($targetDirectory) {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file) {
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFileName);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch(FileException $e) {
            // TODO
        }

        return $fileName;
    }

    public function getTargetDirectory() {
        return $this->targetDirectory;
    }
}