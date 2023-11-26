<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Group;
use App\Entity\SelectionProcess;
use App\Entity\Thematic;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertInstanceOf;

class ThematicTest extends TestCase
{
    private Thematic $thematic;

    protected function setUp(): void
    {
        $this->thematic = new Thematic();
    }

    public function testInstanceOf(): void
    {
        self::assertInstanceOf(Thematic::class, $this->thematic);
    }

    public function testSetAndGetName(): void
    {
        $name = 'Chanel';
        $this->thematic->setName($name);

        self::assertEquals($name, $this->thematic->getName());
        self::assertLessThan(100, strlen($name));
    }

    /**
     * @throws \Exception
     */
    protected function generateRandomText(int $length = 200): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $text = '';

        for ($i = 0; $i < $length; $i++) {
            $text .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $text;
    }

    /**
     * @throws \Exception
     */
    public function testSetAndGetDescription():void
    {
        $this->thematic->setDescription($this->generateRandomText());
        self::assertGreaterThanOrEqual(100, strlen($this->thematic->getDescription()));
    }

    public function testSelectionProcessRelation(): void
    {
        $selectionProcess = new SelectionProcess();
        $this->thematic->setSelectionProcess($selectionProcess);

        self::assertEquals($selectionProcess, $this->thematic->getSelectionProcess());
        self::assertInstanceOf(SelectionProcess::class, $this->thematic->getSelectionProcess());
    }

    public function testGroupRelation(): void
    {
        $group = new Group();
        $this->thematic->addGroup($group);

        self::assertNotNull( $this->thematic->getGroups());
        self::assertIsObject($this->thematic->getGroups());
    }
}
