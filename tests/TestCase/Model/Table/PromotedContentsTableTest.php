<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PromotedContentsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PromotedContentsTable Test Case
 */
class PromotedContentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PromotedContentsTable
     */
    protected $PromotedContents;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PromotedContents',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PromotedContents') ? [] : ['className' => PromotedContentsTable::class];
        $this->PromotedContents = $this->getTableLocator()->get('PromotedContents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PromotedContents);

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
