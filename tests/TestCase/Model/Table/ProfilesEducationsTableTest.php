<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProfilesEducationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProfilesEducationsTable Test Case
 */
class ProfilesEducationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProfilesEducationsTable
     */
    protected $ProfilesEducations;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ProfilesEducations',
        'app.Profiles',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ProfilesEducations') ? [] : ['className' => ProfilesEducationsTable::class];
        $this->ProfilesEducations = $this->getTableLocator()->get('ProfilesEducations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ProfilesEducations);

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
