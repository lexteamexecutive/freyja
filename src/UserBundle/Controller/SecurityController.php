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
        return $this->render(
            'UserBundle:Security:index.html.twig'
        );
    }

    /**
     * @Route("/connexion", name="security_user_login")
     */
    public function loginAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->addFlash('warning', 'Vous êtes déjà connecté, veuillez vous deconnecter si vous souhaitez vous reconnecter');
            return $this->redirectToRoute('security_index');
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        if($error){
            $this->addFlash('error', 'Login ou mot de passe incorrect');
        }
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'UserBundle:Security:login.html.twig',
            [
                'last_username'  => $lastUsername,
            ]
        );
    }

    /**
     * @Route("/utilisateurs", name="security_user_manage")
     */
    public function manageUsersAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles($data->getRoles()[0][0]);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Profil Utilisateur ajouté');
        }else{
          foreach($form->getErrors(true) as $error){
              $this->addFlash('error', $error->getMessage());
          }
        }

        $userRepository = $this->getDoctrine()->getRepository('UserBundle:User');
        $users = $userRepository->findAll();

        return $this->render(
            'UserBundle:Security:register.html.twig',
            [
              'form'  => $form->createView(),
              'users' => $users,
            ]
        );
    }
}
