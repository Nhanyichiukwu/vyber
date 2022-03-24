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
 * @method \App\Model\Entity\Audio newEmptyEntity()
 * @method \App\Model\Entity\Audio newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Audio[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Audio get($primaryKey, $options = [])
 * @method \App\Model\Entity\Audio findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Audio patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Audio[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Audio|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Audio saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Audio[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Audio[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Audio[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Audio[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
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
            ->requirePresence('id', 'create')
            ->notEmptyString('id');

        $validator
            ->scalar('refid')
            ->maxLength('refid', 20)
            ->allowEmptyString('refid', null, 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->requirePresence('slug', 'create')
            ->notEmptyString('slug');

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
            ->scalar('author_refid')
            ->maxLength('author_refid', 20)
            ->requirePresence('author_refid', 'create')
            ->notEmptyString('author_refid');

        $validator
            ->scalar('genre_refid')
            ->maxLength('genre_refid', 20)
            ->allowEmptyString('genre_refid');

        $validator
            ->scalar('album_refid')
            ->maxLength('album_refid', 20)
            ->allowEmptyString('album_refid');

        $validator
            ->scalar('author_location')
            ->maxLength('author_location', 255)
            ->allowEmptyString('author_location');

        $validator
            ->scalar('categories')
            ->maxLength('categories', 16777215)
            ->allowEmptyString('categories');

        $validator
            ->scalar('url')
            ->maxLength('url', 255)
            ->requirePresence('url', 'create')
            ->notEmptyString('url');

        $validator
            ->scalar('file_mime_type')
            ->maxLength('file_mime_type', 45)
            ->requirePresence('file_mime_type', 'create')
            ->notEmptyFile('file_mime_type');

        $validator
            ->scalar('content_type')
            ->maxLength('content_type', 100)
            ->requirePresence('content_type', 'create')
            ->notEmptyString('content_type');

        $validator
            ->scalar('counterpart_refid')
            ->maxLength('counterpart_refid', 20)
            ->allowEmptyString('counterpart_refid')
            ->add('counterpart_refid', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->dateTime('release_date')
            ->allowEmptyDateTime('release_date');

        $validator
            ->scalar('privacy')
            ->notEmptyString('privacy');

        $validator
            ->scalar('status')
            ->notEmptyString('status');

        $validator
            ->boolean('is_debut')
            ->allowEmptyString('is_debut');

        $validator
            ->boolean('monetize')
            ->allowEmptyString('monetize');

        $validator
            ->scalar('language')
            ->maxLength('language', 255)
            ->allowEmptyString('language');

        $validator
            ->scalar('orientation')
            ->allowEmptyString('orientation');

        $validator
            ->scalar('thumbnail')
            ->maxLength('thumbnail', 255)
            ->allowEmptyString('thumbnail');

        $validator
            ->allowEmptyString('total_plays');

        $validator
            ->allowEmptyString('number_of_people_played');

        $validator
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
        $rules->add($rules->isUnique(['counterpart_refid']), ['errorField' => 'counterpart_refid']);

        return $rules;
    }

    public function findPublished(Query $query, array $options = [])
    {
        return $query->where(['Audios.status' => 'published']);
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
    public function findByType(Query $query, array $options)
    {
        $query = $query->where(['Audios.audio_type' => $options['type']]);
        $Videos = $this->getAssociation('Videos')->getTarget();
        $musicVideos = $Videos->find('byType', ['type' => 'music']);
        $query->unionAll($musicVideos);

        if (!empty($options)) {
            $query = $query->applyOptions($options);
        }
        return $query;
    }

    /**
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findLatest(Query $query, array $options = [])
    {
        $latest = $query->newExpr()->between(
            'Audios.created',
            new \DateTime('now'),
            new \DateTime('-7 days')
        );
        $result = $query->select(['latest' => $latest])
            ->enableAutoFields();
        return $result;
    }

    public function findTop(Query $query, array $options = [])
    {

        return $query;
    }
}
