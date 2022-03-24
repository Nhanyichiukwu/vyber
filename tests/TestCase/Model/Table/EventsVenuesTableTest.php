<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EventsVenuesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EventsVenuesTable Test Case
 */
class EventsVenuesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EventsVenuesTable
     */
    protected $EventsVenues;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
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
        $config = $this->getTableLocator()->exists('EventsVenues') ? [] : ['className' => EventsVenuesTable::class];
        $this->EventsVenues = $this->getTableLocator()->get('EventsVenues', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->EventsVenues);

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
