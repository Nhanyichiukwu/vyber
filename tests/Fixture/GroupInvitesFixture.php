<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * GroupInvitesFixture
 */
class GroupInvitesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'biginteger', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'group_id' => ['type' => 'biginteger', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'sender_refid' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'invitee_refid' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'status' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => 'pending', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => true, 'default' => 'current_timestamp()', 'comment' => ''],
        'modified' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => true, 'default' => 'current_timestamp()', 'comment' => ''],
        '_indexes' => [
            'sender_refid' => ['type' => 'index', 'columns' => ['sender_refid'], 'length' => []],
            'invitee_refid' => ['type' => 'index', 'columns' => ['invitee_refid'], 'length' => []],
            'group_id' => ['type' => 'index', 'columns' => ['group_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'group_invites_ibfk_1' => ['type' => 'foreign', 'columns' => ['group_id'], 'references' => ['groups', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'group_invites_ibfk_3' => ['type' => 'foreign', 'columns' => ['invitee_refid'], 'references' => ['users', 'refid'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'group_invites_ibfk_2' => ['type' => 'foreign', 'columns' => ['sender_refid'], 'references' => ['users', 'refid'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'group_id' => 1,
                'sender_refid' => 'Lorem ipsum dolor ',
                'invitee_refid' => 'Lorem ipsum dolor ',
                'status' => 'Lorem ipsum dolor sit amet',
                'created' => 1626675333,
                'modified' => 1626675333,
            ],
        ];
        parent::init();
    }
}
