<?php

namespace App\Controller;

use App\Memory\CreateMemoryCommand;
use App\Memory\ListMemoryQuery;
use App\Memory\ListRandomMemoryQuery;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/memory")
 */
class MemoryController extends AbstractController
{
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }
    /**
     * @Route("", name="create_memory", methods={"POST"})
     */
    public function createMemory(
        Request $request
    ): Response {
        $data = json_decode($request->getContent(), true);
        $dateCreated = new DateTime();
        $memoryEnvelope = $this->messageBus->dispatch(new CreateMemoryCommand($data['data'], $dateCreated));
        /** @var StampInterface $memoryMessage */
        $memoryMessage = $memoryEnvelope->last(HandledStamp::class);
        $memoryId = $memoryMessage->getResult();

        $listMemoryEnvelope = $this->messageBus->dispatch(new ListMemoryQuery($memoryId));
        /** @var StampInterface $listMemoryMessage */
        $listMemoryMessage = $listMemoryEnvelope->last(HandledStamp::class);
        $memory = $listMemoryMessage->getResult();

        $json = json_encode([
            'id' => $memory->getId(),
            'data' => $memory->getData(),
            'dateCreated' => $memory->getDateCreated()->format('Y-m-d')
        ]);

        return new Response($json, 201, [
            'Content-Type' => 'application/json',
            'Access-Controll-Allow-Origin' => '*'
        ]);
    }

    /**
     * @Route("/{id}", name="list_memory", methods={"GET"}, requirements={"id"="\d+"})
     * @param int $id
     */
    public function list(int $id): Response
    {
        try {
            $memoryEnvelope = $this->messageBus->dispatch(new ListMemoryQuery($id));
            /** @var StampInterface $memoryMessage */
            $memoryMessage = $memoryEnvelope->last(HandledStamp::class);
            $memory = $memoryMessage->getResult();
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
     */
    public function listRandom(): Response
    {
        $memoryEnvelope = $this->messageBus->dispatch(new ListRandomMemoryQuery());
        /** @var StampInterface $memoryMessage */
        $memoryMessage = $memoryEnvelope->last(HandledStamp::class);
        $memory = $memoryMessage->getResult();

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
