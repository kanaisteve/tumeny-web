<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/team', name: 'team.')]
class TeamController extends AbstractController
{

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(TeamRepository $teamRepository): Response
    {
        return $this->render('team/index.html.twig', [
            'teams' => $teamRepository->findAll(),
            'pageTitle' => 'Staff Members',
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, TeamRepository $teamRepository): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teamRepository->add($team, $form, true);

            // $targetDirectory = $this->getParameter('avatars_directory');
            // $teamRepository->addWithFile($team, $form, $targetDirectory, true);

            return $this->redirectToRoute('team.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/new.html.twig', [
            'team' => $team,
            'form' => $form,
            'pageTitle' => 'Add Staff Members',
        ]);
    }

    #[Route('/show/{id}', name: 'show', methods: ['GET'])]
    public function show(Team $team): Response
    {
        return $this->render('team/show.html.twig', [
            'team' => $team,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Team $team, TeamRepository $teamRepository): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teamRepository->add($team, $form, true);

            return $this->redirectToRoute('team.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/edit.html.twig', [
            'team' => $team,
            'form' => $form,
            'pageTitle' => 'Edit Staff Member',
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['GET'])]
    public function delete(Request $request, Team $team, TeamRepository $teamRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'You do not have permission to permission to perform this action. Please contact your administrator.');

        //if ($this->isCsrfTokenValid('delete'.$team->getId(), $request->request->get('_token'))) {
        $teamRepository->remove($team, true);
        //}

        return $this->redirectToRoute('team.index', [], Response::HTTP_SEE_OTHER);
    }
}
