<?php

namespace App\Controller;

use App\Memory\CreateMemory;
use App\Memory\ListMemory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/memory")
 */
class MemoryController extends AbstractController
{
    /**
     * @Route("", name="create_memory", methods={"POST"})
     */
    public function createMemory(
        Request $request,
        CreateMemory $createMemory,
        ListMemory $listMemory
        ): Response
    {
        $data = json_decode($request->getContent(), true);
        $memoryId = $createMemory->create($data['text']);

        $memory = $listMemory->findById($memoryId);
        $json = json_encode([
            'id' => $memory->getId(),
            'data' => $memory->getData(),
            'dateCreated' => $memory->getDateCreated()->format('Y-m-d')
        ]);

        return new Response($json, 201);
    }

    /**
     * @Route("/{id}", name="list_memory", methods={"GET"})
     * @param int $id
     */
    public function list(int $id, ListMemory $listMemory): Response
    {
        $memory = $listMemory->findById($id);
        $json = json_encode([
            'id' => $memory->getId(),
            'data' => $memory->getData(),
            'dateCreated' => $memory->getDateCreated()->format('Y-m-d')
        ]);

        return new Response($json, 200);
    }
}