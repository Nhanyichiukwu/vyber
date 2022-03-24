<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProfilesGenresTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProfilesGenresTable Test Case
 */
class UserGenresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProfilesGenresTable
     */
    protected $UserGenres;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.UserGenres',
        'app.Profiles',
        'app.Genres',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('UserGenres') ? [] : ['className' => ProfilesGenresTable::class];
        $this->UserGenres = $this->getTableLocator()->get('UserGenres', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->UserGenres);

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
