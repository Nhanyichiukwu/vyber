<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersRatingsFixture
 */
class UsersRatingsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'biginteger', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'user_refid' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'actor_refid' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'rating' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'review' => ['type' => 'text', 'length' => 16777215, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => true, 'default' => 'current_timestamp()', 'comment' => ''],
        'modified' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => true, 'default' => 'current_timestamp()', 'comment' => ''],
        '_indexes' => [
            'user_refid' => ['type' => 'index', 'columns' => ['user_refid'], 'length' => []],
            'actor_refid' => ['type' => 'index', 'columns' => ['actor_refid'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'users_ratings_ibfk_2' => ['type' => 'foreign', 'columns' => ['actor_refid'], 'references' => ['users', 'refid'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'users_ratings_ibfk_1' => ['type' => 'foreign', 'columns' => ['user_refid'], 'references' => ['users', 'refid'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'user_refid' => 'Lorem ipsum dolor ',
                'actor_refid' => 'Lorem ipsum dolor ',
                'rating' => 1,
                'review' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => 1627313464,
                'modified' => 1627313464,
            ],
        ];
        parent::init();
    }
}
