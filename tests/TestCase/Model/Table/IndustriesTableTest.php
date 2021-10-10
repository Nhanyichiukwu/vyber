<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\IndustriesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\IndustriesTable Test Case
 */
class IndustriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\IndustriesTable
     */
    protected $Industries;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Industries',
        'app.Genres',
        'app.Roles',
        'app.TalentHub',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Industries') ? [] : ['className' => IndustriesTable::class];
        $this->Industries = $this->getTableLocator()->get('Industries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Industries);

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
