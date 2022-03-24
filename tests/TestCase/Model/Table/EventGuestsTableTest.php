<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EventGuestsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EventGuestsTable Test Case
 */
class EventGuestsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EventGuestsTable
     */
    protected $EventGuests;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.EventGuests',
        'app.EventVenues',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('EventGuests') ? [] : ['className' => EventGuestsTable::class];
        $this->EventGuests = $this->getTableLocator()->get('EventGuests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->EventGuests);

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
