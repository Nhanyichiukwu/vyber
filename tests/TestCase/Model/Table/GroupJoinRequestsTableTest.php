<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GroupJoinRequestsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GroupJoinRequestsTable Test Case
 */
class GroupJoinRequestsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GroupJoinRequestsTable
     */
    protected $GroupJoinRequests;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.GroupJoinRequests',
        'app.Groups',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('GroupJoinRequests') ? [] : ['className' => GroupJoinRequestsTable::class];
        $this->GroupJoinRequests = $this->getTableLocator()->get('GroupJoinRequests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->GroupJoinRequests);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
