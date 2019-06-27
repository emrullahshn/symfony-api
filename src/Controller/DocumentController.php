<?php

namespace App\Controller;

use App\Entity\Comment;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Document;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DocumentController
 * @package App\Controller
 */
class DocumentController extends Controller
{
    /**
     * @Route(path="/get-all-documents", name="get_all_documents", methods={"GET"})
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function getDocuments(EntityManagerInterface $entityManager): JsonResponse
    {
        $documents = $entityManager->getRepository(Document::class)->findAll();

        if ($documents === null) {
            return new JsonResponse([
                'errorCode' => JsonResponse::HTTP_NOT_FOUND,
                'errorMessage' => 'Documents Not Found.'
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        $jsonData = [];
        foreach ($documents as $document) {
            $jsonData[$document->getId()] = $document->jsonSerialize();

            /**
             * @var Comment $comment
             */
            foreach ($document->getComments() as $comment) {
                $jsonData[$comment->getDocument()->getId()]['comments'][] = $comment->jsonSerialize();
            }
        }

        return new JsonResponse($jsonData, JsonResponse::HTTP_OK);
    }

    /**
     * @Route(path="document/{id}", name="get_document", methods={"GET"})
     * @param int $id
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function getDocument(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $document = $entityManager->getRepository(Document::class)->find($id);

        if ($document === null) {
            return new JsonResponse([
                'errorCode' => JsonResponse::HTTP_NOT_FOUND,
                'errorMessage' => 'Document Not Found.'
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        $jsonData = $document->jsonSerialize();

        /**
         * @var Comment $comment
         */
        foreach ($document->getComments() as $comment) {
            $jsonData['comments'][] = $comment->jsonSerialize();
        }

        return new JsonResponse($jsonData, JsonResponse::HTTP_OK);
    }
}
