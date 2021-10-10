<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\ContextMenusComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\ContextMenuComponent Test Case
 */
class ContextMenusComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\ContextMenusComponent
     */
    protected $ContextMenu;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->ContextMenu = new ContextMenusComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ContextMenu);

        parent::tearDown();
    }
}
