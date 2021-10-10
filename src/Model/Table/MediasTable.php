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
        $this->setDisplayField('refid');
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
            ->scalar('author_refid')
            ->maxLength('author_refid', 20)
            ->requirePresence('author_refid', 'create')
            ->allowEmptyString('author_refid', null);

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
            ->allowEmptyFile('file_path', null);

        $validator
            ->scalar('permalink')
            ->maxLength('permalink', 255)
            ->requirePresence('permalink', 'create')
            ->allowEmptyFile('permalink', null);

        $validator
            ->scalar('file_mime')
            ->maxLength('file_mime', 45)
            ->requirePresence('file_mime', 'create')
            ->allowEmptyFile('file_mime', null);

        $validator
            ->scalar('media_type')
            ->requirePresence('media_type', 'create')
            ->allowEmptyString('media_type', null);

        $validator
            ->scalar('classification')
            ->maxLength('classification', 100)
            ->allowEmptyString('classification');

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
     *
     * @param \Cake\ORM\Query $query
     * @param array $options
     * @return \Cake\ORM\Query
     */
    public function findByClassification(Query $query, array $options = [])
    {
        $classification = $options['classification'];
        return $query->where([
            'classification' => $classification
        ]);
    }

    public function findByMediaType(Query $query, array $options = [])
    {
        $mediaType = $options['media_type'];
        return $query->where(['media_type' => $mediaType]);
    }
}
