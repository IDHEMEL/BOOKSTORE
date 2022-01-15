<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use App\Repository\AuteurRepository;
use App\Repository\GenreRepository;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/genre')]
class GenreController extends AbstractController
{
    #[Route('/', name: 'genre_index', methods: ['GET'])]
    public function index(GenreRepository $genreRepository,LivreRepository $livreRepository,AuteurRepository $auteurRepository): Response
    {
        return $this->render('genre/index.html.twig', [
            'livres' => $livreRepository->findAll(),
            'genres' => $genreRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'genre_new', methods: ['GET', 'POST'])]
    public function new(GenreRepository $genreRepository,LivreRepository $livreRepository,Request $request, EntityManagerInterface $entityManager): Response
    {
        $genre = new Genre();
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($genre);
            $entityManager->flush();

            return $this->redirectToRoute('genre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('genre/new.html.twig', [
            'livres'=> $livreRepository->findAll(),
            'genres'=> $genreRepository->findAll(),
            'genre' => $genre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'genre_show', methods: ['GET'])]
    public function show(GenreRepository $genreRepository,LivreRepository $livreRepository,Genre $genre): Response
    {
        return $this->render('genre/show.html.twig', [
            'livres'=> $livreRepository->findAll(),
            'genres'=> $genreRepository->findAll(),
            'genre' => $genre,
        ]);
    }

    #[Route('/{id}/edit', name: 'genre_edit', methods: ['GET', 'POST'])]
    public function edit(GenreRepository $genreRepository,LivreRepository $livreRepository,Request $request, Genre $genre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('genre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('genre/edit.html.twig', [
            'livres'=> $livreRepository->findAll(),
            'genres'=> $genreRepository->findAll(),
            'genre' => $genre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'genre_delete', methods: ['POST'])]
    public function delete(Request $request, Genre $genre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$genre->getId(), $request->request->get('_token'))) {
            $entityManager->remove($genre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('genre_index', [], Response::HTTP_SEE_OTHER);
    }
}
