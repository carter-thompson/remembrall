<?php

namespace App\Memory;

use DateTime;

class CreateMemoryCommand
{
    /**
     * @var string
     */
    private $data;

    /**
     * @var DateTime
     */
    private $dateCreated;

    public function __construct(string $data, DateTime $dateCreated)
    {
        $this->data = $data;
        $this->dateCreated = $dateCreated;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function getDateCreated(): DateTime
    {
        return $this->dateCreated;
    }
}