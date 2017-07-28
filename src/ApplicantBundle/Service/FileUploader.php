<?php

namespace ApplicantBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload($applicant, UploadedFile $file)
    {
        $fileName = 'CV_'.$applicant->getAllName().'.'.$file->guessExtension();

        $file->move(
            $this->getTargetDir(),
            $fileName
        );

        return $fileName;
    }

    public function getTargetDir()
    {
        return $this->targetDir;
    }

    public function deleteFile($fileName)
    {
        unlink($this->getTargetDir().'/'.$fileName);
    }
}
