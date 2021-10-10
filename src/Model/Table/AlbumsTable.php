<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Albums Model
 *
 * @method \App\Model\Entity\Album get($primaryKey, $options = [])
 * @method \App\Model\Entity\Album newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Album[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Album|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Album|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Album patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Album[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Album findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AlbumsTable extends Table
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

        $this->setTable('albums');
        $this->setDisplayField('refid');
        $this->setPrimaryKey('refid');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Owners', [
            'foreignKey' => 'owner_refid',
            'joinType' => 'INNER',
            'className' => 'Users'
        ]);

        $this->hasMany('Photos', [
            'foreignKey' => 'album_refid',
//            'joinType' => 'INNER',
//            'className' => 'AlbumItems'
        ]);//->setConditions(['AlbumItems.item_type =' => 'photo']);

        $this->hasMany('Songs', [
            'foreignKey' => 'album_refid',
            'joinType' => 'INNER',
            'className' => 'Medias'
        ])->setConditions(['Medias.classification =' => 'song', 'Albums.type =' => 'audio']);

        $this->hasMany('Videos', [
            'foreignKey' => 'album_refid',
            'joinType' => 'INNER'
        ])->setConditions(['Albums.type =' => 'video']);
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
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('refid')
            ->requirePresence('refid', 'create')
            ->maxLength('refid', 20)
            ->allowEmptyString('refid', null);

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
            ->scalar('media_type')
            ->maxLength('media_type', 45)
            ->requirePresence('media_type', 'create')
            ->allowEmptyString('media_type', null);

        $validator
            ->scalar('counterpart')
            ->maxLength('counterpart', 20)
            ->allowEmptyString('counterpart');

        $validator
            ->dateTime('release_date')
            ->allowEmptyDateTime('release_date');

        $validator
            ->boolean('is_debut')
            ->allowEmptyString('is_debut');

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

    public function findByOwner(Query $query, array $options = [])
    {
        return $query->where(['Albums.owner_refid' => $options['owner']]);
    }

    public function findByPrivacy(Query $query, array $options = [])
    {
        $accessLevel = (array) $options['privacy'];
        return $query->whereInList('Albums.privacy', $accessLevel);
    }

    public function findByMediaType(Query $query, array $options = [])
    {
        return $query->where(['Albums.media_type' => $options['media_type']]);
    }
}
