<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function manageUsersAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles($form->getData()->getRoles()[0][0]);
            $userManager = $this->get('user.manager')->createUser($user);

            $this->addFlash('success', 'Profil Utilisateur ajouté');
        } else {
            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('error', $error->getMessage());
            }
        }

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $users = $this->getUsersByRole();

        return $this->render(
            'UserBundle:User:template.html.twig',
            [
                'form'  => $form->createView(),
                'users' => $users,
            ]
        );
    }

    /**
     * @Route("/utilisateurs/supprimer/{user}", name="security_user_delete", requirements={"page": "\d+"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteUserAction(User $user): JsonResponse
    {
        if($this->get('security.token_storage')->getToken()->getUser() === $user) {
            return new JsonResponse([
                'message' => 'Vous ne pouvez pas vous supprimez votre utilisateur actuel',
            ]);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($user);
        $em->flush();

        return new JsonResponse([
            'success' => true,
        ]);
    }

    private function getUsersByRole(): array
    {
        $userRepository = $this->getDoctrine()->getRepository('UserBundle:User');

        if ($this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            return $userRepository->findAll();
        } else {
            return $userRepository->findAllUF();
        }
    }
}
