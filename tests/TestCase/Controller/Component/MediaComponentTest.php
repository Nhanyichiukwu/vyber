<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\MediaComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\MediaComponent Test Case
 */
class MediaComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\MediaComponent
     */
    protected $Media;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Media = new MediaComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Media);

        parent::tearDown();
    }
}
