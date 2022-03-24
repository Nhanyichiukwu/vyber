<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AudiosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AudiosTable Test Case
 */
class AudiosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AudiosTable
     */
    protected $Audios;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Audios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Audios') ? [] : ['className' => AudiosTable::class];
        $this->Audios = $this->getTableLocator()->get('Audios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Audios);

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
