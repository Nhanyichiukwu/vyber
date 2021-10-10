<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GuestsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GuestsTable Test Case
 */
class GuestsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GuestsTable
     */
    protected $Guests;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
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
        $config = $this->getTableLocator()->exists('Guests') ? [] : ['className' => GuestsTable::class];
        $this->Guests = $this->getTableLocator()->get('Guests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Guests);

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
     * Test findByIp method
     *
     * @return void
     */
    public function testFindByIp(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test findByCountry method
     *
     * @return void
     */
    public function testFindByCountry(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test findByRegion method
     *
     * @return void
     */
    public function testFindByRegion(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
