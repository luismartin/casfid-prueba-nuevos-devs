<?php
namespace App\Domain\Shared;

interface Entity
{
    public function toArray(): array;
}