<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Playlists Model
 *
 * @method \App\Model\Entity\Playlist get($primaryKey, $options = [])
 * @method \App\Model\Entity\Playlist newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Playlist[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Playlist|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Playlist|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Playlist patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Playlist[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Playlist findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PlaylistsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config):void
    {
        parent::initialize($config);

        $this->setTable('playlists');
        $this->setDisplayField('name');
        $this->setPrimaryKey('refid');

        $this->addBehavior('Timestamp');
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
            ->requirePresence('id', 'create')
            ->allowEmptyString('id', null);

        $validator
            ->scalar('refid')
            ->maxLength('refid', 20)
            ->allowEmptyString('refid', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', null);

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->requirePresence('slug', 'create')
            ->allowEmptyString('slug', null)
            ->add('slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('description')
            ->maxLength('description', 16777215)
            ->allowEmptyString('description');

        $validator
            ->scalar('owner_refid')
            ->maxLength('owner_refid', 20)
            ->requirePresence('owner_refid', 'create')
            ->allowEmptyString('owner_refid', null);

        $validator
            ->scalar('type')
            ->maxLength('type', 45)
            ->requirePresence('type', 'create')
            ->allowEmptyString('type', null);

        $validator
            ->dateTime('release_date')
            ->allowEmptyDateTime('release_date');

        $validator
            ->scalar('privacy')
            ->requirePresence('privacy', 'create')
            ->allowEmptyString('privacy', null);

        $validator
            ->boolean('published')
            ->allowEmptyString('published');

        $validator
            ->dateTime('mofified')
            ->requirePresence('mofified', 'create')
            ->allowEmptyDateTime('mofified', null);

        return $validator;
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
        $rules->add($rules->isUnique(['slug']));

        return $rules;
    }
}
