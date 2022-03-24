<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EventsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EventsTable Test Case
 */
class EventsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EventsTable
     */
    protected $Events;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Events',
        'app.EventTypes',
        'app.Guests',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Events') ? [] : ['className' => EventsTable::class];
        $this->Events = $this->getTableLocator()->get('Events', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Events);

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

    /**
     * Test findDueEvents method
     *
     * @return void
     */
    public function testFindDueEvents(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test findInvites method
     *
     * @return void
     */
    public function testFindInvites(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test findByUser method
     *
     * @return void
     */
    public function testFindByUser(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
