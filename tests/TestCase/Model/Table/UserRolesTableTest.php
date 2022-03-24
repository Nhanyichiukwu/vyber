<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProfilesRolesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProfilesRolesTable Test Case
 */
class UserRolesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProfilesRolesTable
     */
    protected $UserRoles;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.UserRoles',
        'app.Profiles',
        'app.Roles',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('UserRoles') ? [] : ['className' => ProfilesRolesTable::class];
        $this->UserRoles = $this->getTableLocator()->get('UserRoles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->UserRoles);

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
