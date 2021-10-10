<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersRatingsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersRatingsTable Test Case
 */
class UsersRatingsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersRatingsTable
     */
    protected $UsersRatings;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.UsersRatings',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('UsersRatings') ? [] : ['className' => UsersRatingsTable::class];
        $this->UsersRatings = $this->getTableLocator()->get('UsersRatings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->UsersRatings);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
