<?php

namespace App\Memory;

use App\Entity\Memory;
use App\Repository\MemoryRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateMemoryHandler implements MessageHandlerInterface
{
    private $memoryRepository;

    public function __construct(MemoryRepository $memoryRepository)
    {
        $this->memoryRepository = $memoryRepository;
    }

    public function __invoke(CreateMemoryCommand $command): int
    {
        $data = $command->getData();
        $dateCreated = $command->getDateCreated();
        $memory = new Memory();
        $memory->setData($data);
        $memory->setDateCreated($dateCreated);
        
        return $this->memoryRepository->create($memory);
    }
}