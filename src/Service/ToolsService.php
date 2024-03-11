<?php

namespace App\Service;

use Random\Randomizer;
use Symfony\Component\String\Slugger\SluggerInterface;

readonly class ToolsService
{
    public function __construct(
        private SluggerInterface $slugger,
        )
    {
    }

    public function getGeneratorSlugger(string $clientName): string
    {
        return $this->slugger->slug(trim($clientName), '_', 'fr');
    }

    public function getGeneratorRefNumber(string $clientName): string
    {
        $ramdomizer = new Randomizer();
        $nameClient = $this->getGeneratorSlugger($clientName);

        return sprintf(
            'RefNumber_'.$nameClient.'_%s',
            $ramdomizer->getBytesFromString('abcdefghijklmnopqrstuvwxyz0123456789', 8)
        );
    }
}
