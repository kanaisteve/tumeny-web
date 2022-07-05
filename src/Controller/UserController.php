<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\User;
use App\Form\RoleType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Require ROLE_ADMIN for all the actions of this controller
 */
//#[IsGranted('ROLE_ADMIN', message: 'You do not have permission to access this page')]
#[Route('/admin/users', name: 'users.')]
class UserController extends AbstractController
{
    private $em;
    private $userRepository;
    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager) {
        $this->userRepository = $userRepository;
        $this->em = $entityManager;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $this->userRepository->findAll(),
            'pageTitle' => 'Users',
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $profile = new Profile();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword($user, $form->get('password')->getData())
            );

            $profile->setAvatar('/uploads/avatars/avatar.png');
            $profile->setUser($user);

            $this->em->persist($user);
            $this->em->persist($profile);
            $this->em->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('users.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
            'pageTitle' => 'Add New User',
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserPasswordHasherInterface $userPasswordHasher, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $userRepository->add($user, true);

            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword($user, $form->get('password')->getData())
            );

            $this->em->persist($user);
            $this->em->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('users.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'pageTitle' => 'Edit User',
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['GET'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
//        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
        $userRepository->remove($user, true);
//        }

        return $this->redirectToRoute('users.index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/add-role', name: 'add.role', methods: ['GET', 'POST'])]
    public function addRole(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(RoleType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->addRole($user, $form, true);

            return $this->redirectToRoute('users.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/add_role.html.twig', [
            'user' => $user,
            'form' => $form,
            'pageTitle' => 'Add Role',
        ]);
    }
}
