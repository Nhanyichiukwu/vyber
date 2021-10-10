<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Audios Model
 *
 * @method \App\Model\Entity\Audio get($primaryKey, $options = [])
 * @method \App\Model\Entity\Audio newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Audio[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Audio|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Audio|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Audio patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Audio[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Audio findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AudiosTable extends Table
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
        $this->setDisplayField('refid');
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
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('refid')
            ->requirePresence('refid', 'create')
            ->maxLength('refid', 20)
            ->allowEmptyString('refid', 'create');

        $validator
            ->scalar('refkey')
            ->maxLength('refkey', 8)
            ->requirePresence('refkey', 'create')
            ->allowEmptyString('refkey', null);

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
            ->scalar('file_mime_type')
            ->maxLength('file_mime_type', 45)
            ->requirePresence('file_mime_type', 'create')
            ->allowEmptyFile('file_mime_type', null);

        $validator
            ->scalar('audio_type')
            ->maxLength('audio_type', 100)
            ->requirePresence('audio_type', 'create')
            ->allowEmptyString('audio_type', null);

        $validator
            ->scalar('author_refid')
            ->maxLength('author_refid', 20)
            ->requirePresence('author_refid', 'create')
            ->allowEmptyString('author_refid', null);

        $validator
            ->scalar('video_refid')
            ->maxLength('video_refid', 20)
            ->allowEmptyString('video_refid')
            ->add('video_refid', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('album_refid')
            ->maxLength('album_refid', 20)
            ->allowEmptyString('album_refid');

        $validator
            ->scalar('genre_refid')
            ->maxLength('genre_refid', 20)
            ->allowEmptyString('genre_refid');

        $validator
            ->scalar('category_refid')
            ->maxLength('category_refid', 20)
            ->allowEmptyString('category_refid');

        $validator
            ->dateTime('release_date')
            ->allowEmptyDateTime('release_date');

        $validator
            ->scalar('status')
            ->requirePresence('status', 'create')
            ->allowEmptyString('status', null);

        $validator
            ->boolean('is_debut')
            ->allowEmptyString('is_debut');

        $validator
            ->boolean('monetize')
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
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['video_refid']));

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

    /**
     *
     * @param Query $query
     * @param array $options
     */
    public function findMusic(Query $query, array $options)
    {
        return $query->where(['audio_type' => 'music']);
    }
}
