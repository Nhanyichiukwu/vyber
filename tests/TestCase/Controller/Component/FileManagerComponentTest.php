<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\FileManagerComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\FileManagerComponent Test Case
 */
class FileManagerComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\FileManagerComponent
     */
    protected $FileManager;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->FileManager = new FileManagerComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->FileManager);

        parent::tearDown();
    }
}
