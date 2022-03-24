<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\Database\Expression\QueryExpression;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Medias Model
 *
 * @property \App\Model\Table\EntertainmentTypesTable&\Cake\ORM\Association\BelongsTo $EntertainmentTypes
 * @property \App\Model\Table\GroupsTable&\Cake\ORM\Association\BelongsToMany $Groups
 *
 * @method \App\Model\Entity\Media newEmptyEntity()
 * @method \App\Model\Entity\Media newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Media[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Media get($primaryKey, $options = [])
 * @method \App\Model\Entity\Media findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Media patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Media[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Media|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Media saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Media[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Media[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Media[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Media[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MediasTable extends Table
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

        $this->setTable('medias');
        $this->setDisplayField('title');
        $this->setPrimaryKey('refid');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Authors', [
            'foreignKey' => 'author_refid',
            'joinType' => 'INNER',
            'className' => 'Users'
        ]);
        $this->belongsTo('Albums', [
            'foreignKey' => 'album_refid',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Genres', [
            'foreignKey' => 'genre_refid',
            'joinType' => 'LEFT'
        ]);

//        $this->hasOne('OriginalPosts', [
//            'foreignKey' => 'refid',
//            'bindingKey' => 'original_post_refid',
//            'joinType' => 'LEFT',
//            'className' => 's'
//        ])->setProperty('originalPost');

        $this->hasOne('Counterparts', [
            'foreignKey' => 'refid',
            'bindingKey' => 'audio_or_video_counterpart_refid',
            'joinType' => 'LEFT',
            'className' => 'Medias'
        ]);
        $this->belongsTo('EntertainmentTypes', [
            'foreignKey' => 'entertainment_type_id',
        ]);
        $this->belongsToMany('Groups', [
            'foreignKey' => 'media_id',
            'targetForeignKey' => 'group_id',
            'joinTable' => 'groups_medias',
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
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('refid')
            ->maxLength('refid', 20)
            ->requirePresence('refid', 'create')
            ->notEmptyString('refid');

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
            ->allowEmptyString('categories');

        $validator
            ->scalar('file_path')
            ->maxLength('file_path', 255)
            ->requirePresence('file_path', 'create')
            ->notEmptyFile('file_path');

        $validator
            ->scalar('file_mime')
            ->maxLength('file_mime', 45)
            ->requirePresence('file_mime', 'create')
            ->notEmptyString('file_mime');

        $validator
            ->scalar('media_type')
            ->requirePresence('media_type', 'create')
            ->notEmptyString('media_type');

        $validator
            ->scalar('target_audience')
            ->allowEmptyString('target_audience');

        $validator
            ->scalar('audience_locations')
            ->maxLength('audience_locations', 255)
            ->allowEmptyString('audience_locations');

        $validator
            ->scalar('age_restriction')
            ->allowEmptyString('age_restriction');

        $validator
            ->scalar('audio_or_video_counterpart_refid')
            ->maxLength('audio_or_video_counterpart_refid', 20)
            ->allowEmptyString('audio_or_video_counterpart_refid');

        $validator
            ->date('recording_date')
            ->allowEmptyDate('recording_date');

        $validator
            ->date('release_date')
            ->allowEmptyDate('release_date');

        $validator
            ->scalar('privacy')
            ->allowEmptyString('privacy');

        $validator
            ->scalar('status')
            ->allowEmptyString('status');

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
        $rules->add($rules->existsIn(['entertainment_type_id'], 'EntertainmentTypes'), ['errorField' => 'entertainment_type_id']);

        return $rules;
    }

    /**
     *
     * @param \Cake\ORM\Query $query
     * @param array $options
     * @return \Cake\ORM\Query
     */
    public function findByEntertainmentType(Query $query, array $options = [])
    {
        $entertainmentType = $options['entertainmentType'];
        if (!empty($options)) {
            $query = $query->applyOptions($options);
        }
        return $query->matching(
            'EntertainmentTypes',
            function (Query $q)
            use ($entertainmentType) {
                return $q->where([
                    'EntertainmentTypes.slug' => $entertainmentType
                ]);
            }
        );
    }

    public function findByMediaType(Query $query, array $options = [])
    {
        $mediaType = $options['media_type'];
        return $query->where(['media_type' => $mediaType]);
    }

    public function findPublished(Query $query, array $options = [])
    {
        return $query->where(['status' => 'published']);
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
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findLatest(Query $query, array $options = [])
    {
        $latest = $query->newExpr()->between(
            'Medias.created',
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
