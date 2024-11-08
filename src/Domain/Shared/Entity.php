<?php
namespace App\Domain\Shared;

interface Entity
{
    public function toArray(): array;
    public function getId(): ?int;
    public function setId(int $id): void;
}