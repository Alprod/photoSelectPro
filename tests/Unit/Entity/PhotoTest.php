<?php

namespace App\Tests\Unit\Entity;

use App\Entity\BinomialPreSelection;
use App\Entity\Client;
use App\Entity\Photo;
use PHPUnit\Framework\TestCase;

class PhotoTest extends TestCase
{
    private $photo;

    protected function setUp(): void
    {
        $this->photo = new Photo();
    }

    public function testSetAndGetName(): void
    {
        $name = 'image';
        $this->photo->setName($name);
        self::assertEquals($name, $this->photo->getName());
    }

    public function testSetAndGetFilename(): void
    {
        $filename = 'default.png';
        $this->photo->setFilename($filename);

        self::assertEquals($filename, $this->photo->getFilename());
        self::assertIsString($this->photo->getFilename());
    }

    public function testRelationClient(): void
    {
        $client = new Client();

        $this->photo->setClient($client);
        self::assertNotNull($this->photo->getClient());
    }

    public function testRelationBinomialPreSelection(): void
    {
        $bps = new BinomialPreSelection();
        $this->photo->addBinomialPreSelection($bps);
        self::assertCount(1, $this->photo->getBinomialPreSelections());
    }

    public function testRemoveBinomialPreSelection(): void
    {
        $bsp1 = new BinomialPreSelection();
        $bsp2 = new BinomialPreSelection();

        $this->photo->addBinomialPreSelection($bsp1);
        $this->photo->addBinomialPreSelection($bsp2);

        self::assertNotNull($this->photo->getBinomialPreSelections());
        self::assertCount(2, $this->photo->getBinomialPreSelections());

        $this->photo->removeBinomialPreSelection($bsp1);
        self::assertCount(1, $this->photo->getBinomialPreSelections());
        self::assertNull($bsp1->getPhotos());

        $this->photo->removeBinomialPreSelection(new BinomialPreSelection());

        self::assertCount(1, $this->photo->getBinomialPreSelections());
    }
}
