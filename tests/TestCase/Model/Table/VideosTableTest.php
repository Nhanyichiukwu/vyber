<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VideosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VideosTable Test Case
 */
class VideosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\VideosTable
     */
    protected $Videos;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Videos',
        'app.MediaViews',
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
        $config = $this->getTableLocator()->exists('Videos') ? [] : ['className' => VideosTable::class];
        $this->Videos = $this->getTableLocator()->get('Videos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Videos);

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

    /**
     * Test findByType method
     *
     * @return void
     */
    public function testFindByType(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test categorize method
     *
     * @return void
     */
    public function testCategorize(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test findByAuthor method
     *
     * @return void
     */
    public function testFindByAuthor(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test findMusic method
     *
     * @return void
     */
    public function testFindMusic(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test findLatest method
     *
     * @return void
     */
    public function testFindLatest(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test findPublished method
     *
     * @return void
     */
    public function testFindPublished(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
