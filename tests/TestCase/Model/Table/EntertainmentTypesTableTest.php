<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EntertainmentTypesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EntertainmentTypesTable Test Case
 */
class EntertainmentTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EntertainmentTypesTable
     */
    protected $EntertainmentTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.EntertainmentTypes',
        'app.Medias',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('EntertainmentTypes') ? [] : ['className' => EntertainmentTypesTable::class];
        $this->EntertainmentTypes = $this->getTableLocator()->get('EntertainmentTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->EntertainmentTypes);

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
