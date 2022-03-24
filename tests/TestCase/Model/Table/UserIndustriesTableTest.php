<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProfilesIndustriesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProfilesIndustriesTable Test Case
 */
class UserIndustriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProfilesIndustriesTable
     */
    protected $UserIndustries;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.UserIndustries',
        'app.Profiles',
        'app.Industries',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('UserIndustries') ? [] : ['className' => ProfilesIndustriesTable::class];
        $this->UserIndustries = $this->getTableLocator()->get('UserIndustries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->UserIndustries);

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
