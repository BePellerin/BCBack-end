<?php

namespace App\Controller;

use App\Entity\Collecs;
use App\Form\CollecsType;
use App\Repository\CollecsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/collecs')]
#[IsGranted("ROLE_ADMIN", "ROLE_USER")]
class CollecsController extends AbstractController
{
    #[Route('/', name: 'app_collecs_index', methods: ['GET'])]
    public function index(CollecsRepository $collecsRepository): Response
    {
        return $this->render('collecs/index.html.twig', [
            'collecs' => $collecsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_collecs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $collec = new Collecs();
        $form = $this->createForm(CollecsType::class, $collec);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($collec);
            $entityManager->flush();

            return $this->redirectToRoute('app_collecs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('collecs/new.html.twig', [
            'collec' => $collec,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_collecs_show', methods: ['GET'])]
    public function show(Collecs $collec): Response
    {
        return $this->render('collecs/show.html.twig', [
            'collec' => $collec,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_collecs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Collecs $collec, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CollecsType::class, $collec);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_collecs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('collecs/edit.html.twig', [
            'collec' => $collec,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_collecs_delete', methods: ['POST'])]
    public function delete(Request $request, Collecs $collec, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collec->getId(), $request->request->get('_token'))) {
            $entityManager->remove($collec);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_collecs_index', [], Response::HTTP_SEE_OTHER);
    }
}
