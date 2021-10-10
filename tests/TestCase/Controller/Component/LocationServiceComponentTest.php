<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\LocationServiceComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\LocationServiceComponent Test Case
 */
class LocationServiceComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\LocationServiceComponent
     */
    protected $LocationService;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->LocationService = new LocationServiceComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->LocationService);

        parent::tearDown();
    }
}
