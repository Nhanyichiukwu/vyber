<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CategoryTypesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CategoryTypesTable Test Case
 */
class CategoryTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CategoryTypesTable
     */
    protected $CategoryTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CategoryTypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CategoryTypes') ? [] : ['className' => CategoryTypesTable::class];
        $this->CategoryTypes = $this->getTableLocator()->get('CategoryTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CategoryTypes);

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
