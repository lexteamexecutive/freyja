<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\UserType;
use UserBundle\Entity\User;

  /**
   * @Route("/securite", name="security")
   */
class SecurityController extends Controller
{
    /**
     * @Route("/", name="security_index")
     */
    public function indexAction()
    {
        return $this->render('UserBundle:Security:index.html.twig');
    }

    /**
     * @Route("/connexion", name="security_user_login")
     */
    public function loginAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('security_index');
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'UserBundle:Security:login.html.twig',
            [
                'error'          => $error,
                'last_username'  => $lastUsername,
            ]
        );
    }

    /**
     * @Route("/inscription", name="security_user_registration")
     */
    public function registerAction(Request $request)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles(['ROLE_USER']);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('notice', 'Profil Utilisateur ajouté');
        }

        return $this->render(
            'UserBundle:Security:register.html.twig',
            [
              'form' => $form->createView(),
            ]
        );
    }
}
