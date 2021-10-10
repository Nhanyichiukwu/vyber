<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Events Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $EventTypes
 *
 * @method \App\Model\Entity\Event get($primaryKey, $options = [])
 * @method \App\Model\Entity\Event newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Event[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Event|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Event|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Event patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Event[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Event findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EventsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('events');
        $this->setDisplayField('refid');
        $this->setPrimaryKey('refid');

        $this->addBehavior('Timestamp');

        $this->hasMany('Venues', [
            'foreignKey' => 'event_refid',
            'className' => 'EventVenues'
        ])->setProperty('venues');

        $this->hasMany('Guests', [
            'foreignKey' => 'event_refid',
            'className' => 'EventGuests'
        ])->setProperty('guests');

        $this->belongsTo('EventTypes', [
            'foreignKey' => 'event_type_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id');

        $validator
            ->scalar('refid')
            ->maxLength('refid', 20)
            ->requirePresence('refid', 'create')
            ->allowEmptyString('refid', null);

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->allowEmptyString('title', null);

        $validator
            ->scalar('description')
            ->maxLength('description', 16777215)
            ->allowEmptyString('description');

        $validator
            ->scalar('privacy')
            ->allowEmptyString('privacy');

        $validator
            ->scalar('image')
            ->maxLength('image', 20)
            ->allowEmptyString('image');

        $validator
            ->scalar('user_refid')
            ->maxLength('user_refid', 20)
            ->requirePresence('user_refid', 'create')
            ->allowEmptyString('user_refid', null);

        $validator
            ->scalar('host_name')
            ->maxLength('host_name', 255)
            ->requirePresence('host_name', 'create')
            ->allowEmptyString('host_name', null);

        $validator
            ->scalar('status')
            ->allowEmptyString('status');

        return $validator;
    }


    public function findDue(Query $query, array $options = [])
    {
        $timeframe = '+7 days';
        if (array_key_exists('timeframe', $options) && !empty($options['timeframe'])) {
            $timeframe = $options['timeframe'];
        }
        $query = $query
            ->where([
                'Events.user_refid' => $options['actor']
            ])
            ->contain(['Venues' => ['Guests']])
            ->matching('Venues', function ($q) use ($timeframe, $options) {
                $q = $q->where([
                        'Venues.start_date >=' => new \DateTime($timeframe)
                    ])
                    ->contain([
                        'Guests' => [
                            'Inviters' => ['Profiles'],
                            'Invitees' => ['Profiles']
                        ],
                    ])
                    ->matching('Guests', function ($q) use ($options) {
                        return $q->where([
                            'OR' => [
                                ['Guests.inviter_refid' => $options['actor']],
                                ['Guests.guest_refid' => $options['actor']]
                            ]
                        ]);
                    });
                return $q;
            });

        return $query;
    }

    public function findInvites(Query $query, array $options)
    {
        $query = $query->matching('Guests', function ($q) use ($options) {
            $actor = $options['actor'];
            $filter = '';
            if (array_key_exists('filter', $options)) {
                $filter = $options['filter'];
            }

            $q = $q->whereNull('response')
                ->contain([
                    'Inviters' => ['Profiles'],
                    'Invitees' => ['Profiles']
                ]);

            switch ($filter) {
                case 'sent':
                    $q = $q->andWhere(['inviter_refid' => $actor]);
                    break;

                case 'received':
                    $q = $q->andWhere(['guest_refid' => $actor]);
                    break;

                default:
                    $q = $q->andWhere([
                        'OR' => [
                            ['inviter_refid' => $actor],
                            ['guest_refid' => $actor]
                        ]
                    ]);
                    break;
            }

            return $q;
        });

        return $query;
    }

    public function findByUser(Query $query, array $options)
    {
        return $query->where(['user_refid' => $options['user']]);
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['event_type_id'], 'EventTypes'));

        return $rules;
    }
}
