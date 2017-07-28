<?php

namespace FrontBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/")
 */
class FrontController extends Controller
{
    /**
     * @Route("/", name="front_dashboard")
     */
    public function dashboardAction()
    {
        return $this->render('FrontBundle:Dashboard:index.html.twig');
    }

    /**
     * @Route("/search", name="front_search")
     *
     * Expected result:
     * {
     * 'text': 'group',
     * 'children': [
     * {
     *  'id': 'imageName',
     *    'text': 'value 1'
     * },
     *  {
     *    'id': 'imageName',
     *    'text': 'value 1'
     *  }
     *]
     *}
     */
    public function searchAction(Request $request)
    {

        $applicantRepo = $this->getDoctrine()->getRepository('ApplicantBundle:Applicant');
        $applicants = $applicantRepo->findAllByParam($request->query->get('q'));

        if (count($applicants) > 0) {
            $result = [
                [
                    'text'     => 'Candidats',
                    'children' => $applicants,
                ],
            ];
        } else {
            $result = [];
        }

        return new JsonResponse($result);
    }
}
