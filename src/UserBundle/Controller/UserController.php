<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\UserType;
use UserBundle\Entity\User;

class UserController extends Controller
{
    /**
     * @Route("/utilisateurs", name="user_manage")
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param  Request $request
     * @return render  UserBundle:User:template.html.twig
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
     * Action used by ajax call in user datatable
     *
     * @Route("/utilisateur/supprimer/{user}", name="user_delete", requirements={"page": "\d+"})
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     *
     * @param  User         $user User deleted
     * @return JsonResponse success | message
     */
    public function deleteUserAction(User $user): JsonResponse
    {
        if ($this->isSameUser($user)) {
            return new JsonResponse([
                'message' => 'Vous ne pouvez pas supprimer votre utilisateur actuel.',
            ]);
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return new JsonResponse([
            'success' => true,
        ]);
    }


    /**
     * Action used by ajax call in user datatable
     *
     * @Route("/utilisateur/modifier/{user}/statut", name="user_update_isenabled", requirements={"page": "\d+"})
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param  User         $user User updated
     * @return JsonResponse success | message
     */
    public function updateUserIsActiveAction(User $user): JsonResponse
    {
        if ($this->isSameUser($user)) {
            return new JsonResponse([
                'message' => 'Vous ne pouvez pas vous supprimez votre utilisateur actuel.',
            ]);
        }

        if ($user->isEnabled()) {
            $user->disable();
        } else {
            $user->enable();
        }

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new JsonResponse([
            'success' => true,
        ]);
    }

    /**
     * Get Users by the current User role
     *
     * @return array of Users
     */
    private function getUsersByRole(): array
    {
        $userRepository = $this->getDoctrine()->getRepository('UserBundle:User');

        if ($this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            return $userRepository->findAll();
        } else {
            return $userRepository->findAllUF();
        }
    }

    /**
     * Check if the User is the current User
     *
     * @param  User    $user User to test
     * @return boolean true if user = current | false if not
     */
    private function isSameUser(User $user): bool
    {
        if ($this->get('security.token_storage')->getToken()->getUser() === $user) {
            return true;
        } else {
            return false;
        }
    }
}
