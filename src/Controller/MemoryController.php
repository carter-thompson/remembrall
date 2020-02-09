<?php

namespace App\Controller;

use App\Memory\CreateMemory;
use App\Memory\ListMemory;
use App\Memory\ListRandomMemory;
use Exception;
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
    ): Response {
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
     * @Route("/{id}", name="list_memory", methods={"GET"}, requirements={"id"="\d+"})
     * @param int $id
     * @param ListMemory $listMemory
     */
    public function list(int $id, ListMemory $listMemory): Response
    {
        try {
            $memory = $listMemory->findById($id);
            $json = json_encode([
                'id' => $memory->getId(),
                'data' => $memory->getData(),
                'dateCreated' => $memory->getDateCreated()->format('Y-m-d')
            ]);
            $status = 200;
        } catch (Exception $e) {
            $json = json_encode(['{"error":"Don\'t remember that one.."}']);
            $status = 404;
        }

        return new Response($json, $status, [
            'Content-Type' => 'application/json',
            'Access-Control-Allow-Origin' => '*'
        ]);
    }

    /**
     * @Route("/random", name="list_random_memory", methods={"GET"})
     * @param ListRandomMemory $listRandomMemory
     */
    public function listRandom(ListRandomMemory $listRandomMemory): Response
    {
        $memory = $listRandomMemory->getRandom();

        $json = json_encode([
            'id' => $memory->getId(),
            'data' => $memory->getData(),
            'dateCreated' => $memory->getDateCreated()->format('Y-m-d')
        ]);

        return new Response($json, 200, [
            'Content-Type' => 'application/json',
            'Access-Control-Allow-Origin' => '*'
        ]);
    }
}
