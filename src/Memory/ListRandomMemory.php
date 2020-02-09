<?php

namespace App\Memory;

use App\Entity\Memory;
use App\Repository\MemoryRepository;

class ListRandomMemory
{
    /**
     * @var MemoryRepository $memoryRepository
     */
    private $memoryRepository;

    public function __construct(MemoryRepository $memoryRepository)
    {
        $this->memoryRepository = $memoryRepository;
    }

    public function getRandom(): Memory
    {
        $memories = $this->memoryRepository->getAll();
        $memory = $memories[array_rand($memories)];
        return $memory;
    }
}