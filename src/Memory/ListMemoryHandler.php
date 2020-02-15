<?php

namespace App\Memory;

use App\Entity\Memory;
use App\Memory\Exception\MemoryNotFoundException;
use App\Repository\MemoryRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ListMemoryHandler implements MessageHandlerInterface
{
    /**
     * @var MemoryRepository
     */
    private $memoryRepository;

    public function __construct(MemoryRepository $memoryRepository)
    {
        $this->memoryRepository = $memoryRepository;
    }

    public function __invoke(ListMemoryQuery $query): Memory
    {
        $memoryId = $query->getId();
        $memory = $this->memoryRepository->findOneById($memoryId);

        if (!$memory) {
            throw new MemoryNotFoundException("Memory {$memoryId} does not exist.");
        }
        return $memory;
    }
}