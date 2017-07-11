<?php

namespace ApplicantBundle\Controller;

use ApplicantBundle\Entity\Applicant;
use ApplicantBundle\Form\ApplicantType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;

class ApplicantController extends Controller
{
    /**
     * @Route("/candidats/accueil", name="applicant_home")
     */
    public function homeAction(Request $request)
    {
        $applicant = new Applicant();
        $form = $this->createForm(ApplicantType::class, $applicant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $applicant->getCV();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('cvs_directory'),
                $fileName
            );

            // Update the 'cv' property to store the PDF file name
            // instead of its contents
            $applicant->setCV($fileName);

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($applicant);
            $em->flush();

            return $this->redirect(
                $this->generateUrl(
                    'applicant_view',
                    [
                        'applicant' => $applicant->getId(),
                    ]
                )
            );
        }

        return $this->render(
            'ApplicantBundle:Home:index.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/candidat/{applicant}", name="applicant_view", requirements={"page": "\d+"})
     */
    public function readAction(Applicant $applicant)
    {
        return $this->render(
            'ApplicantBundle:Home:read.html.twig',
            [
                'applicant' => $applicant,
            ]
        );
    }

    /**
     * @Route("/candidat/{applicant}/cv", name="applicant_download_cv", requirements={"page": "\d+"})
     */
    public function downloadAction(Applicant $applicant)
    {
        $cvPath = '/var/www/freyja-data' . '/' . $applicant->getCV();

        return $this->file($cvPath);
    }
}
