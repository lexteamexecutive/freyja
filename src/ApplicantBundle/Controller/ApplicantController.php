<?php

namespace ApplicantBundle\Controller;

use ApplicantBundle\Entity\Applicant;
use ApplicantBundle\Form\ApplicantType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

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
            $evaluation = $applicant->getEvaluation();
            $evaluation->setApplicant($applicant);

            $em = $this->getDoctrine()->getManager();
            $em->persist($applicant);
            $em->persist($evaluation);
            $em->flush();

            $this->get('applicant_bag')->addApplicantInBag($applicant);

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
    * @Route("/candidat/{applicant}", name="applicant_view")
     */
    public function readAction(Request $request, Applicant $applicant)
    {
        if ($applicant->getCv() !== null) {
            $currentCv = $applicant->getCv();
            $applicant->setCv(
                new File($this->getParameter('cvs_directory').'/'.$applicant->getCv())
            );
        }
        $form = $this->createForm(ApplicantType::class, $applicant);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($currentCv !== null && $applicant->getCv() === null) {
                $applicant->setCv($currentCv);
            } else {
                $this->get('applicant.cv_uploader')->deleteFile($currentCv);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($applicant);
            $em->persist($applicant->getEvaluation());
            $em->flush();

            $this->get('applicant_bag')->addApplicantInBag($applicant);
        }

        return $this->render(
            'ApplicantBundle:Home:index.html.twig',
            [
                'form' => $form->createView(),
                'applicant' => $applicant,
            ]
        );
    }

    /**
     * @Route("/candidat/{applicant}/cv", name="applicant_download_cv", requirements={"applicant": "\d+"})
     */
    public function downloadAction(Applicant $applicant)
    {
        $cvPath = $this->get('applicant.cv_uploader')->getTargetDir() . '/' . $applicant->getCv();

        return $this->file($cvPath);
    }
}
