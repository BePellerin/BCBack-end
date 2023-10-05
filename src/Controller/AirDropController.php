<?php

namespace App\Controller;

use App\Entity\AirDrop;
use App\Form\AirDropType;
use App\Repository\AirDropRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/airdrop')]
#[IsGranted("ROLE_ADMIN")]
class AirDropController extends AbstractController
{
    #[Route('/', name: 'app_airdrop_index', methods: ['GET'])]
    public function index(AirDropRepository $airdropRepository): Response
    {
        return $this->render('drop/index.html.twig', [
            'drops' => $airdropRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_airdrop_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $airdrop = new AirDrop();
        $form = $this->createForm(AirDropType::class, $airdrop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($airdrop);
            $entityManager->flush();

            return $this->redirectToRoute('app_airdrop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('drop/new.html.twig', [
            'drop' => $airdrop,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_airdrop_show', methods: ['GET'])]
    public function show(AirDrop $airdrop): Response
    {
        return $this->render('drop/show.html.twig', [
            'airdrop' => $airdrop,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_airdrop_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AirDrop $airdrop, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AirDropType::class, $airdrop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_airdrop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('drop/edit.html.twig', [
            'airdrop' => $airdrop,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_airdrop_delete', methods: ['POST'])]
    public function delete(Request $request, AirDrop $airdrop, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$airdrop->getId(), $request->request->get('_token'))) {
            $entityManager->remove($airdrop);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_airdrop_index', [], Response::HTTP_SEE_OTHER);
    }
}
