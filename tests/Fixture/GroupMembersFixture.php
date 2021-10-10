<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * GroupMembersFixture
 */
class GroupMembersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'group_id' => ['type' => 'biginteger', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'user_refid' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'invited_by' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => true, 'default' => 'current_timestamp()', 'comment' => ''],
        'modified' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => true, 'default' => 'current_timestamp()', 'comment' => ''],
        'status' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => 'active', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'invited_at' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'approved_by' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'approved_at' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'is_admin' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'group_id' => ['type' => 'index', 'columns' => ['group_id'], 'length' => []],
            'user_refid' => ['type' => 'index', 'columns' => ['user_refid'], 'length' => []],
            'invited_by' => ['type' => 'index', 'columns' => ['invited_by'], 'length' => []],
            'approved_by' => ['type' => 'index', 'columns' => ['approved_by'], 'length' => []],
        ],
        '_constraints' => [
            'group_members_ibfk_1' => ['type' => 'foreign', 'columns' => ['group_id'], 'references' => ['groups', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'group_members_ibfk_4' => ['type' => 'foreign', 'columns' => ['approved_by'], 'references' => ['users', 'refid'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'group_members_ibfk_3' => ['type' => 'foreign', 'columns' => ['invited_by'], 'references' => ['users', 'refid'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'group_members_ibfk_2' => ['type' => 'foreign', 'columns' => ['user_refid'], 'references' => ['users', 'refid'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'group_id' => 1,
                'user_refid' => 'Lorem ipsum dolor ',
                'invited_by' => 'Lorem ipsum dolor ',
                'created' => 1626675285,
                'modified' => 1626675285,
                'status' => 'Lorem ipsum dolor sit amet',
                'invited_at' => 1626675285,
                'approved_by' => 'Lorem ipsum dolor ',
                'approved_at' => 1626675285,
                'is_admin' => 1,
            ],
        ];
        parent::init();
    }
}
