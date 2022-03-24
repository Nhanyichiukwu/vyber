<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\TimelineComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\TimelineComponent Test Case
 */
class TimelineComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\TimelineComponent
     */
    protected $Timeline;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Timeline = new TimelineComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Timeline);

        parent::tearDown();
    }
}
