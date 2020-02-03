<?php
namespace App\Memory;

use App\Entity\Memory;
use App\Repository\MemoryRepository;
use DateTime;

class CreateMemory
{
    private $memoryRepo;

    public function __construct(MemoryRepository $memoryRepo)
    {
        $this->memoryRepo = $memoryRepo;
    }

    public function create(string $text): int
    {
        $memory = new Memory();
        $memory->setData($text);
        $memory->setDateCreated(new DateTime());

        return $this->memoryRepo->create($memory);
    }

}