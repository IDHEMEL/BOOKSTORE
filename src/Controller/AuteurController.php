<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurType;
use App\Repository\AuteurRepository;
use App\Repository\GenreRepository;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/auteur')]
class AuteurController extends AbstractController
{
    #[Route('/', name: 'auteur_index', methods: ['GET'])]
    public function index(AuteurRepository $auteurRepository,LivreRepository $livreRepository,GenreRepository $genreRepository): Response
    {
        $livres = $livreRepository->findAll();
        $genres = $genreRepository->findAll();
        return $this->render('auteur/index.html.twig', [
            'livres' => $livres,
            'genres' => $genres,
            'auteurs' => $auteurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'auteur_new', methods: ['GET', 'POST'])]
    public function new(LivreRepository $livreRepository,GenreRepository $genreRepository,Request $request, EntityManagerInterface $entityManager): Response
    {
        $auteur = new Auteur();
        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($auteur);
            $entityManager->flush();

            return $this->redirectToRoute('auteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('auteur/new.html.twig', [
            'livres' => $livreRepository->findAll(),
            'genres' => $genreRepository->findAll(),
            'auteur' => $auteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'auteur_show', methods: ['GET'])]
    public function show(LivreRepository $livreRepository,GenreRepository $genreRepository,Auteur $auteur): Response
    {
        return $this->render('auteur/show.html.twig', [
            'livres' => $livreRepository->findAll(),
            'genres' => $genreRepository->findAll(),
            'auteur' => $auteur,
        ]);
    }

    #[Route('/{id}/edit', name: 'auteur_edit', methods: ['GET', 'POST'])]
    public function edit(LivreRepository $livreRepository,GenreRepository $genreRepository,Request $request, Auteur $auteur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('auteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('auteur/edit.html.twig', [
            'livres' => $livreRepository->findAll(),
            'genres' => $genreRepository->findAll(),
            'auteur' => $auteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'auteur_delete', methods: ['POST'])]
    public function delete(Request $request, Auteur $auteur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$auteur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($auteur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('auteur_index', [], Response::HTTP_SEE_OTHER);
    }
}
