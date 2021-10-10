<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserGenresFixture
 */
class UserGenresFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'biginteger', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'profile_id' => ['type' => 'biginteger', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'genre_id' => ['type' => 'biginteger', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => true, 'default' => 'current_timestamp()', 'comment' => ''],
        'modified' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => true, 'default' => 'current_timestamp()', 'comment' => ''],
        '_indexes' => [
            'profile_id' => ['type' => 'index', 'columns' => ['profile_id'], 'length' => []],
            'genre_id' => ['type' => 'index', 'columns' => ['genre_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'user_genres_ibfk_2' => ['type' => 'foreign', 'columns' => ['genre_id'], 'references' => ['genres', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'user_genres_ibfk_1' => ['type' => 'foreign', 'columns' => ['profile_id'], 'references' => ['profiles', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'profile_id' => 1,
                'genre_id' => 1,
                'created' => 1633093016,
                'modified' => 1633093016,
            ],
        ];
        parent::init();
    }
}
