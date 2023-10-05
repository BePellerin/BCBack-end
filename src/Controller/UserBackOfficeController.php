<?php

namespace App\Controller;

use App\Entity\UserBackOffice;
use App\Form\UserBackOfficeType;
use App\Repository\UserBackOfficeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/back/office')]
class UserBackOfficeController extends AbstractController
{
    #[Route('/', name: 'app_user_back_office_index', methods: ['GET'])]
    public function index(UserBackOfficeRepository $userBackOfficeRepository): Response
    {
        return $this->render('user_back_office/index.html.twig', [
            'user_back_offices' => $userBackOfficeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_back_office_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userBackOffice = new UserBackOffice();
        $form = $this->createForm(UserBackOfficeType::class, $userBackOffice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($userBackOffice);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_back_office_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_back_office/new.html.twig', [
            'user_back_office' => $userBackOffice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_back_office_show', methods: ['GET'])]
    public function show(UserBackOffice $userBackOffice): Response
    {
        return $this->render('user_back_office/show.html.twig', [
            'user_back_office' => $userBackOffice,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_back_office_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserBackOffice $userBackOffice, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserBackOfficeType::class, $userBackOffice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_back_office_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_back_office/edit.html.twig', [
            'user_back_office' => $userBackOffice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_back_office_delete', methods: ['POST'])]
    public function delete(Request $request, UserBackOffice $userBackOffice, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userBackOffice->getId(), $request->request->get('_token'))) {
            $entityManager->remove($userBackOffice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_back_office_index', [], Response::HTTP_SEE_OTHER);
    }
}
