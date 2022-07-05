<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Form\ProfileType;
use App\Repository\ProfileRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile', name: 'profile.')]
class ProfileController extends AbstractController
{
    private $em;
    private $userRepository;
    private $profileRepository;
    public function __construct(UserRepository $userRepository, ProfileRepository $profileRepository, EntityManagerInterface $entityManager) {
        $this->em = $entityManager;
        $this->userRepository = $userRepository;
        $this->profileRepository = $profileRepository;
    }

    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'pageTitle' => 'My Profile',
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/{user_id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Profile $profile): Response
    {
        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->profileRepository->add($profile, true);

            return $this->redirectToRoute('profile.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profile/edit.html.twig', [
            'form' => $form,
            'user' => $this->getUser(),
            'pageTitle' => 'Edit Profile',
        ]);
    }
}
