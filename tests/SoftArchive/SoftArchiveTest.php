<?php

namespace FelipeDeCampos\LaravelSoftArchive\Test;


use FelipeDeCampos\LaravelSoftArchive\Test\Models\ArchivedModel;
use PHPUnit\Framework\TestCase;

class SoftArchiveTest extends TestCase
{

    /**
     * @covers \FelipeDeCampos\LaravelSoftArchive\Test\Models\ArchivedModel::getArchivedAtColumn
     */
    public function testArchivedAtColumn()
    {
        $ArchivedModel = new ArchivedModel();

        $this->assertInstanceOf(ArchivedModel::class, $ArchivedModel);
        $this->assertSame('archived_at', $ArchivedModel->getArchivedAtColumn());
    }
}