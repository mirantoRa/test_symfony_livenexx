<?php

namespace App\Controller;

use App\Entity\SousRubrique;
use App\Form\SousRubrique1Type;
use App\Repository\SousRubriqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sous/rubrique')]
class SousRubriqueController extends AbstractController
{
    #[Route('/', name: 'app_sous_rubrique_index', methods: ['GET'])]
    public function index(SousRubriqueRepository $sousRubriqueRepository): Response
    {
        return $this->render('sous_rubrique/index.html.twig', [
            'sous_rubriques' => $sousRubriqueRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_sous_rubrique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sousRubrique = new SousRubrique();
        $form = $this->createForm(SousRubrique1Type::class, $sousRubrique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sousRubrique);
            $entityManager->flush();

            return $this->redirectToRoute('app_sous_rubrique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sous_rubrique/new.html.twig', [
            'sous_rubrique' => $sousRubrique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sous_rubrique_show', methods: ['GET'])]
    public function show(SousRubrique $sousRubrique): Response
    {
        return $this->render('sous_rubrique/show.html.twig', [
            'sous_rubrique' => $sousRubrique,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sous_rubrique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SousRubrique $sousRubrique, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SousRubrique1Type::class, $sousRubrique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_sous_rubrique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sous_rubrique/edit.html.twig', [
            'sous_rubrique' => $sousRubrique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sous_rubrique_delete', methods: ['POST'])]
    public function delete(Request $request, SousRubrique $sousRubrique, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sousRubrique->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($sousRubrique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sous_rubrique_index', [], Response::HTTP_SEE_OTHER);
    }
}
