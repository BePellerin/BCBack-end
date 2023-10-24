<?php

namespace App\Controller;

use App\Entity\Nft;
use App\Form\NftType;
use App\Repository\NftRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/nft')]
class NftController extends AbstractController
{
    
    #[Route('/', name: 'app_nft_index', methods: ['GET'])]
    #[IsGranted("ROLE_ADMIN", "ROLE_USER")]
    public function index(NftRepository $nftRepository): Response
    {
        return $this->render('nft/index.html.twig', [
            'nfts' => $nftRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_nft_new', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_ADMIN", "ROLE_USER")]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $nft = new Nft();
        $form = $this->createForm(NftType::class, $nft);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($nft);
            $entityManager->flush();

            return $this->redirectToRoute('app_nft_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('nft/new.html.twig', [
            'nft' => $nft,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nft_show', methods: ['GET'])]
    #[IsGranted("ROLE_ADMIN", "ROLE_USER")]
    public function show(Nft $nft): Response
    {
        return $this->render('nft/show.html.twig', [
            'nft' => $nft,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_nft_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_ADMIN", "ROLE_USER")]
    public function edit(Request $request, Nft $nft, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NftType::class, $nft);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_nft_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('nft/edit.html.twig', [
            'nft' => $nft,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nft_delete', methods: ['POST'])]
    #[IsGranted("ROLE_ADMIN", "ROLE_USER")]
    public function delete(Request $request, Nft $nft, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nft->getId(), $request->request->get('_token'))) {
            $entityManager->remove($nft);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_nft_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/images/nfts/{filename}", name="nft_image")
     */
    // public function downloadImage(string $filename)
    // {
    //     $path = $this->getParameter('kernel.project_dir') . '/public/images/nfts/' . $filename;
    //     $file = new File($path);
    //     $response = new Response();
    //     $response->headers->set('Content-Type', 'image/jpeg'); // Remplacez par le type MIME approprié
    //     $response->headers->set('Content-Disposition', 'inline; filename="' . $file->getFilename() . '"');
    //     $response->setContent(file_get_contents($file->getPathname()));

    //     return $response;
    // }
}
