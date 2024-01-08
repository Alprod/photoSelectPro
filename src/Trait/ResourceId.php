<?php

namespace App\Trait;

use Doctrine\ORM\Mapping as ORM;

trait ResourceId
{
    #[ORM\Id]
    #[ORM\GeneratedValue('SEQUENCE')]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}