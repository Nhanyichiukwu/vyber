<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EventVenuesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EventVenuesTable Test Case
 */
class EventVenuesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EventVenuesTable
     */
    protected $EventVenues;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.EventVenues',
        'app.EventGuests',
        'app.EventInvitees',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('EventVenues') ? [] : ['className' => EventVenuesTable::class];
        $this->EventVenues = $this->getTableLocator()->get('EventVenues', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->EventVenues);

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
