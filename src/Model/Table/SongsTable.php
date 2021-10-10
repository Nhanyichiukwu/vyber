<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Songs Model
 *
 * @method \App\Model\Entity\Song get($primaryKey, $options = [])
 * @method \App\Model\Entity\Song newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Song[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Song|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Song|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Song patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Song[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Song findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SongsTable extends Table
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

        $this->setTable('audios');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

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
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('refid')
            ->maxLength('refid', 20)
            ->requirePresence('refid', 'create')
            ->allowEmptyString('refid', null)
            ->add('refid', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->allowEmptyString('title', null);

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->requirePresence('slug', 'create')
            ->allowEmptyString('slug', null);

        $validator
            ->scalar('description')
            ->maxLength('description', 16777215)
            ->allowEmptyString('description');

        $validator
            ->scalar('cast')
            ->maxLength('cast', 16777215)
            ->allowEmptyString('cast');

        $validator
            ->scalar('tags')
            ->maxLength('tags', 16777215)
            ->allowEmptyString('tags');

        $validator
            ->scalar('privacy')
            ->requirePresence('privacy', 'create')
            ->allowEmptyString('privacy', null);

        $validator
            ->scalar('author_location')
            ->maxLength('author_location', 255)
            ->allowEmptyString('author_location');

        $validator
            ->scalar('url')
            ->maxLength('url', 255)
            ->requirePresence('url', 'create')
            ->allowEmptyString('url', null);

        $validator
            ->scalar('media_type')
            ->maxLength('media_type', 45)
            ->requirePresence('media_type', 'create')
            ->allowEmptyString('media_type', null);

        $validator
            ->scalar('author_refid')
            ->maxLength('author_refid', 20)
            ->requirePresence('author_refid', 'create')
            ->allowEmptyString('author_refid', null);

        $validator
            ->scalar('video_refid')
            ->maxLength('video_refid', 20)
            ->allowEmptyString('video_refid');

        $validator
            ->scalar('album_refid')
            ->maxLength('album_refid', 20)
            ->allowEmptyString('album_refid');

        $validator
            ->scalar('genre_refid')
            ->maxLength('genre_refid', 20)
            ->requirePresence('genre_refid', 'create')
            ->allowEmptyString('genre_refid', null);

        $validator
            ->scalar('category_refid')
            ->maxLength('category_refid', 20)
            ->allowEmptyString('category_refid');

        $validator
            ->dateTime('release_date')
            ->allowEmptyDateTime('release_date');

        $validator
            ->scalar('is_debute')
            ->allowEmptyString('is_debute');

        $validator
            ->scalar('monetize')
            ->allowEmptyString('monetize');

        $validator
            ->nonNegativeInteger('total_plays')
            ->allowEmptyString('total_plays');

        $validator
            ->nonNegativeInteger('number_of_people_played')
            ->allowEmptyString('number_of_people_played');

        $validator
            ->nonNegativeInteger('number_of_downloads')
            ->allowEmptyString('number_of_downloads');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['refid']));

        return $rules;
    }

    /**
     *
     * @param Query $query
     * @param array $options
     */
    public function findByAuthor(Query $query, array $options)
    {
        return $query->where(['author_refid' => $options['author']]);
    }
}
