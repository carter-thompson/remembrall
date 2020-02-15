<?php

namespace App\Memory;

use App\Entity\Memory;
use App\Repository\MemoryRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ListRandomMemoryHandler implements MessageHandlerInterface
{
    /**
     * @var MemoryRepository
     */
    private $memoryRepository;

    public function __construct(MemoryRepository $memoryRepository)
    {
        $this->memoryRepository = $memoryRepository;
    }

    public function __invoke(ListRandomMemoryQuery $query): Memory
    {
        $memories = $this->memoryRepository->getAll();
        $memory = $memories[array_rand($memories)];
        return $memory;
    }
}