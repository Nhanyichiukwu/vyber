<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HallOfFamersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HallOfFamersTable Test Case
 */
class HallOfFamersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\HallOfFamersTable
     */
    protected $HallOfFamers;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.HallOfFamers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('HallOfFamers') ? [] : ['className' => HallOfFamersTable::class];
        $this->HallOfFamers = $this->getTableLocator()->get('HallOfFamers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->HallOfFamers);

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
