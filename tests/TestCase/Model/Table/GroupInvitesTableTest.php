<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GroupInvitesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GroupInvitesTable Test Case
 */
class GroupInvitesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GroupInvitesTable
     */
    protected $GroupInvites;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.GroupInvites',
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
        $config = $this->getTableLocator()->exists('GroupInvites') ? [] : ['className' => GroupInvitesTable::class];
        $this->GroupInvites = $this->getTableLocator()->get('GroupInvites', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->GroupInvites);

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
