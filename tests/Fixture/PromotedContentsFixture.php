<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PromotedContentsFixture
 */
class PromotedContentsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'biginteger', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'content_refid' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'promoter_refid' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'content_type' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'content_repository' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => true, 'default' => 'current_timestamp()', 'comment' => ''],
        'modified' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => true, 'default' => 'current_timestamp()', 'comment' => ''],
        'published' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => true, 'default' => 'current_timestamp()', 'comment' => ''],
        'status' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => 'active', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'audience_age_bracket' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => '18_and_above', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'audience_gender' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => 'both', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'audience_locations' => ['type' => 'text', 'length' => 4294967295, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'start_date' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => '0000-00-00 00:00:00', 'comment' => ''],
        'end_date' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'budget_currency' => ['type' => 'string', 'length' => 5, 'null' => true, 'default' => 'USD', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'budget_amount' => ['type' => 'float', 'length' => null, 'precision' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => ''],
        '_indexes' => [
            'promoter_refid' => ['type' => 'index', 'columns' => ['promoter_refid'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'content_refid' => ['type' => 'unique', 'columns' => ['content_refid'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // phpcs:enable
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'content_refid' => 'Lorem ipsum dolor ',
                'promoter_refid' => 'Lorem ipsum dolor ',
                'content_type' => 'Lorem ipsum dolor sit amet',
                'content_repository' => 'Lorem ipsum dolor sit amet',
                'created' => 1626300540,
                'modified' => 1626300540,
                'published' => 1626300540,
                'status' => 'Lorem ipsum dolor sit amet',
                'audience_age_bracket' => 'Lorem ipsum dolor sit amet',
                'audience_gender' => 'Lorem ipsum dolor sit amet',
                'audience_locations' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'start_date' => '2021-07-14 22:09:00',
                'end_date' => 'Lorem ipsum dolor sit amet',
                'budget_currency' => 'Lor',
                'budget_amount' => 1,
            ],
        ];
        parent::init();
    }
}
