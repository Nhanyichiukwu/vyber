<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GroupPostsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GroupPostsTable Test Case
 */
class GroupPostsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GroupPostsTable
     */
    protected $GroupPosts;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.GroupPosts',
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
        $config = $this->getTableLocator()->exists('GroupPosts') ? [] : ['className' => GroupPostsTable::class];
        $this->GroupPosts = $this->getTableLocator()->get('GroupPosts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->GroupPosts);

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
