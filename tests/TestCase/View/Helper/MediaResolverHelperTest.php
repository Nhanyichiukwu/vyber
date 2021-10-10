<?php
declare(strict_types=1);

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\MediaResolverHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\MediaResolverHelper Test Case
 */
class MediaResolverHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\View\Helper\MediaResolverHelper
     */
    protected $MediaResolver;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->MediaResolver = new MediaResolverHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MediaResolver);

        parent::tearDown();
    }
}
