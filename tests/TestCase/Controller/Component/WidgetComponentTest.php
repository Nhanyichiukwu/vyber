<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\WidgetComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\WidgetComponent Test Case
 */
class WidgetComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\WidgetComponent
     */
    protected $Widget;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Widget = new WidgetComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Widget);

        parent::tearDown();
    }
}
