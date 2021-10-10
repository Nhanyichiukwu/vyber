<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\ProfileMenusComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\ProfileMenusComponent Test Case
 */
class ProfileMenusComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\ProfileMenusComponent
     */
    protected $ProfileMenus;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->ProfileMenus = new ProfileMenusComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ProfileMenus);

        parent::tearDown();
    }
}
