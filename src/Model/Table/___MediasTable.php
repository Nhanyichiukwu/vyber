<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Medias Model
 *
 * @method \App\Model\Entity\Media get($primaryKey, $options = [])
 * @method \App\Model\Entity\Media newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Media[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Media|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Media|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Media patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Media[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Media findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MediasTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('medias');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        
        $this->belongsTo('Users', [
            'foreignKey' => 'user_refid',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Videos', [
            'foreignKey' => 'media_refid',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Audios', [
            'foreignKey' => 'media_refid',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->nonNegativeInteger('id')
                ->allowEmptyString('id', 'create');

        $validator
                ->scalar('user_refid')
                ->maxLength('user_refid', 20)
                ->requirePresence('user_refid', 'create')
                ->allowEmptyString('user_refid', false);

        $validator
                ->scalar('media_refid')
                ->maxLength('media_refid', 20)
                ->requirePresence('media_refid', 'create')
                ->allowEmptyString('media_refid', false);

        $validator
                ->scalar('media_table')
                ->maxLength('media_table', 255)
                ->requirePresence('media_table', 'create')
                ->allowEmptyString('media_table', false);

        $validator
                ->scalar('media_type')
                ->maxLength('media_type', 255)
                ->requirePresence('media_type', 'create')
                ->allowEmptyString('media_type', false);

        return $validator;
    }

    public function findSongs(Query $query, array $options) {
        return $query->where([
                            'media_type' => 'song'
                        ])
                        ->contain(['Audios']);
    }

    public function findMovies(Query $query, array $options) {
        return $query->where([
                            'media_type' => 'movie'
                        ])
                        ->contain(['Videos']);
    }
    
    public function findComedies(Query $query, array $options)
    {
        return $query->where([
                            'media_type' => 'comedy'
                        ])
                        ->contain(['Videos']);
    }
    
    public function findAudios(Query $query, array $options)
    {
        return $query->where([
                            'media_type' => 'audio'
                        ])
                        ->contain(['Audios']);
    }
}
