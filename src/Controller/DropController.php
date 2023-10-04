<?php

namespace App\Controller;

use App\Entity\Drop;
use App\Form\DropType;
use App\Repository\DropRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/drop')]
#[IsGranted("ROLE_ADMIN")]
class DropController extends AbstractController
{
    #[Route('/', name: 'app_drop_index', methods: ['GET'])]
    public function index(DropRepository $dropRepository): Response
    {
        return $this->render('drop/index.html.twig', [
            'drops' => $dropRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_drop_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $drop = new Drop();
        $form = $this->createForm(DropType::class, $drop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($drop);
            $entityManager->flush();

            return $this->redirectToRoute('app_drop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('drop/new.html.twig', [
            'drop' => $drop,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_drop_show', methods: ['GET'])]
    public function show(Drop $drop): Response
    {
        return $this->render('drop/show.html.twig', [
            'drop' => $drop,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_drop_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Drop $drop, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DropType::class, $drop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_drop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('drop/edit.html.twig', [
            'drop' => $drop,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_drop_delete', methods: ['POST'])]
    public function delete(Request $request, Drop $drop, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$drop->getId(), $request->request->get('_token'))) {
            $entityManager->remove($drop);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_drop_index', [], Response::HTTP_SEE_OTHER);
    }
}
