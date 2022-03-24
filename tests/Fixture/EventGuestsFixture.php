<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EventGuestsFixture
 */
class EventGuestsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'biginteger', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'event_refid' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'event_venue_id' => ['type' => 'biginteger', 'length' => null, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'guest_refid' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'inviter_refid' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'date_invited' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'event_seen' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null],
        'date_seen' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'invite_response_date' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'response' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'event_status' => ['type' => 'string', 'length' => null, 'null' => false, 'default' => 'active', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        '_indexes' => [
            'event_venue_id' => ['type' => 'index', 'columns' => ['event_venue_id'], 'length' => []],
            'guest_refid' => ['type' => 'index', 'columns' => ['guest_refid'], 'length' => []],
            'inviter_refid' => ['type' => 'index', 'columns' => ['inviter_refid'], 'length' => []],
            'event_refid' => ['type' => 'index', 'columns' => ['event_refid'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'event_guests_ibfk_3' => ['type' => 'foreign', 'columns' => ['inviter_refid'], 'references' => ['users', 'refid'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'event_guests_ibfk_2' => ['type' => 'foreign', 'columns' => ['event_venue_id'], 'references' => ['event_venues', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'event_guests_ibfk_1' => ['type' => 'foreign', 'columns' => ['event_refid'], 'references' => ['events', 'refid'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'event_refid' => 'Lorem ipsum dolor ',
                'event_venue_id' => 1,
                'guest_refid' => 'Lorem ipsum dolor ',
                'inviter_refid' => 'Lorem ipsum dolor ',
                'date_invited' => 1643869623,
                'event_seen' => 1,
                'date_seen' => 1643869623,
                'invite_response_date' => 1643869623,
                'response' => 'Lorem ipsum dolor sit amet',
                'event_status' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
