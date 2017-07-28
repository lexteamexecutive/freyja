<?php

namespace ApplicantBundle\EventListener;

use ApplicantBundle\Entity\Applicant;
use ApplicantBundle\Entity\Evaluation;
use ApplicantBundle\Service\FileUploader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ApplicantListener
{
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
        $this->setLastUpdate($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
        $this->setLastUpdate($entity);
    }

    private function uploadFile($entity)
    {
        // upload only works for Applicant entities
        if (!$entity instanceof Applicant) {
            return;
        }

        $file = $entity->getCv();

        // only upload new files
        if (!$file instanceof UploadedFile) {
            return;
        }

        $fileName = $this->uploader->upload($entity, $file);
        $entity->setCv($fileName);
        $entity->setCvLastUpload();
    }

    private function setLastUpdate($entity)
    {
        if ($entity instanceof Applicant) {
            $entity->setLastUpdate();
        }

        if ($entity instanceof Evaluation) {
            $entity->getApplicant()->setLastUpdate();
        }
    }
}
