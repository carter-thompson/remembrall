<?php

namespace App\Memory;

use App\Entity\Memory;
use App\Repository\MemoryRepository;
use Exception;

class ListMemory
{
    private $memoryRepository;

    public function __construct(MemoryRepository $memoryRepository)
    {
        $this->memoryRepository = $memoryRepository;
    }

    public function findById(int $id): Memory
    {
        $memory = $this->memoryRepository->findOneById($id);

        if (!$memory) {
            throw new Exception("Memory {$id} does not exist.");
        }

        return $memory;
    }
}