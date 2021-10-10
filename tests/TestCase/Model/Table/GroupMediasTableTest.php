<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GroupMediasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GroupMediasTable Test Case
 */
class GroupMediasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GroupMediasTable
     */
    protected $GroupMedias;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.GroupMedias',
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
        $config = $this->getTableLocator()->exists('GroupMedias') ? [] : ['className' => GroupMediasTable::class];
        $this->GroupMedias = $this->getTableLocator()->get('GroupMedias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->GroupMedias);

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
