<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProfilesLanguagesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProfilesLanguagesTable Test Case
 */
class ProfilesLanguagesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProfilesLanguagesTable
     */
    protected $ProfilesLanguages;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ProfilesLanguages',
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
        $config = $this->getTableLocator()->exists('ProfilesLanguages') ? [] : ['className' => ProfilesLanguagesTable::class];
        $this->ProfilesLanguages = $this->getTableLocator()->get('ProfilesLanguages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ProfilesLanguages);

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
