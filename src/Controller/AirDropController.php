<?php

namespace App\Controller;

use ApiPlatform\Metadata\Post;
use App\Entity\AirDrop;
use App\Form\AirDropType;
use App\Repository\AirDropRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
// use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface as SerializationSerializerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile; 

#[Route('/air/drop')]
#[AsController]
class AirDropController extends AbstractController
{
    #[Route('/', name: 'app_air_drop_index', methods: ['GET'])]
    #[IsGranted("ROLE_ADMIN", "ROLE_USER")]
    public function index(AirDropRepository $airDropRepository): Response
    {
        return $this->render('air_drop/index.html.twig', [
            'air_drops' => $airDropRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_air_drop_new', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_ADMIN", "ROLE_USER")]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $airDrop = new AirDrop();
        $form = $this->createForm(AirDropType::class, $airDrop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($airDrop);
            $entityManager->flush();

            return $this->redirectToRoute('app_air_drop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('air_drop/new.html.twig', [
            'air_drop' => $airDrop,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_air_drop_show', methods: ['GET'])]
    #[IsGranted("ROLE_ADMIN", "ROLE_USER")]
    public function show(AirDrop $airDrop): Response
    {
        return $this->render('air_drop/show.html.twig', [
            'air_drop' => $airDrop,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_air_drop_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function edit(Request $request, AirDrop $airDrop, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AirDropType::class, $airDrop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_air_drop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('air_drop/edit.html.twig', [
            'air_drop' => $airDrop,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_air_drop_delete', methods: ['POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function delete(Request $request, AirDrop $airDrop, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $airDrop->getId(), $request->request->get('_token'))) {
            $entityManager->remove($airDrop);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_air_drop_index', [], Response::HTTP_SEE_OTHER);
    }

}
    // public function __invoke(Request $request)
    // {
    //     $uploadedFile = $request->attributes->get('imageFile');

    //     // Assurez-vous que 'uploadedFile' n'est pas null
    //     if ($uploadedFile !== null) {
    //         // Attribuez le fichier image à 'uploadedFile'


    //     } else {
    //         // Gérez le cas où 'uploadedFile' est null, par exemple en renvoyant une réponse d'erreur
    //         // ou en lançant une exception appropriée.
    //         // Exemple avec une exception :
    //         throw new \Exception("L'objet 'uploadedFile' est null.");
    //     }
    // }

    // public function __invoke(Request $request)
    // {
    //     $uploadedFile = $request->files->get('file');
    //     // if (!$uploadedFile) {
    //     //     throw new BadRequestHttpException('"file" is required');
    //     // }

    //     $mediaObject = new AirDrop();
    //     $mediaObject->file = $uploadedFile;

    //     return $mediaObject;
    // }

    // public function __invoke(Request $request): AirDrop
    // {
    //     $uploadedFile = $request->files->get('file');
    //     if (!$uploadedFile) {
    //         throw new BadRequestHttpException('"file" is required');
    //     }

    //     $mediaObject = new AirDrop();
    //     $mediaObject->file = $uploadedFile;

    //     return $mediaObject;
    // }

