<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EventsGuestsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EventsGuestsTable Test Case
 */
class EventsGuestsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EventsGuestsTable
     */
    protected $EventsGuests;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.EventsGuests',
        'app.EventsVenues',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('EventsGuests') ? [] : ['className' => EventsGuestsTable::class];
        $this->EventsGuests = $this->getTableLocator()->get('EventsGuests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->EventsGuests);

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
