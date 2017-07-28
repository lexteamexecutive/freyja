<?php

namespace ApplicantBundle\Controller;

use ApplicantBundle\Entity\EvaluationJob;
use ApplicantBundle\Form\EvaluationJobType;
use ApplicantBundle\Entity\EvaluationSpeciality;
use ApplicantBundle\Form\EvaluationSpecialityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EvaluationDataManagerController extends Controller
{
    /**
     * @Route("/manager/evaluation/donnees", name="evaluation_manager_data")
     */
    public function evaluationDataManagerAction(Request $request)
    {
        $job = new EvaluationJob();
        $formEvaluationJob = $this->createForm(EvaluationJobType::class, $job);

        $jobRepository = $this->getDoctrine()->getRepository('ApplicantBundle:EvaluationJob');
        $jobs = $jobRepository->getAllOrdered();

        $formEvaluationJob->handleRequest($request);
        if ($formEvaluationJob->isSubmitted() && $formEvaluationJob->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($job);
            $em->flush();

            $jobs[] = $job;
            $this->addFlash('success', 'Fonction créée');
        }

        $speciality = new EvaluationSpeciality();
        $formEvaluationSpeciality = $this->createForm(EvaluationSpecialityType::class, $speciality);

        $specialityRepository = $this->getDoctrine()->getRepository('ApplicantBundle:EvaluationSpeciality');
        $specialities = $specialityRepository->getAllOrdered();

        $formEvaluationSpeciality->handleRequest($request);
        if ($formEvaluationSpeciality->isSubmitted() && $formEvaluationSpeciality->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($speciality);
            $em->flush();

            $specialities[] = $speciality;
            $this->addFlash('success', 'Spécialité créée');
        }

        return $this->render(
            'ApplicantBundle:EvaluationDataManager:template.html.twig',
            [
                'evaluations' => $jobs,
                'specialities' => $specialities,
                'formEvaluationJob' => $formEvaluationJob->createView(),
                'formEvaluationSpeciality' => $formEvaluationSpeciality->createView(),
            ]
        );
    }
}
