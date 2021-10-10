<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Behavior\CommonBehavior;
use Cake\Database\Expression\QueryExpression;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Videos Model
 *
 * @method \App\Model\Entity\Video get($primaryKey, $options = [])
 * @method \App\Model\Entity\Video newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Video[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Video|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Video|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Video patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Video[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Video findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin CommonBehavior
 */
class VideosTable extends AppTable
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

        $this->setTable('videos');
        $this->setDisplayField('refid');
        $this->setPrimaryKey('refid');

        $this->addBehavior('Timestamp', ['timezone' => 'GMT']);
        $this->addBehavior('Common');

        $this->hasMany('MediaViews', [
            'foreignKey' => 'media_refid'
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
            ->allowEmptyString('id', 'create')
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('refid')
            ->requirePresence('refid', 'create')
            ->maxLength('refid', 20)
            ->allowEmptyString('refid', null);

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmptyString('title');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->allowEmptyString('slug');

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
            ->allowEmptyString('privacy');

        $validator
            ->scalar('author_location')
            ->maxLength('author_location', 255)
            ->allowEmptyString('author_location');

        $validator
            ->scalar('file_path')
            ->maxLength('file_path', 255)
            ->requirePresence('file_path', 'create')
            ->allowEmptyString('file_path', null);

        $validator
            ->scalar('file_mime_type')
            ->maxLength('file_mime_type', 45)
            ->allowEmptyString('file_mime_type');

        $validator
            ->scalar('video_type')
            ->maxLength('video_type', 100)
            ->requirePresence('video_type', 'create')
            ->allowEmptyString('video_type', null);

        $validator
            ->scalar('author_refid')
            ->maxLength('author_refid', 20)
            ->requirePresence('author_refid', 'create')
            ->allowEmptyString('author_refid', null);

        $validator
            ->scalar('audio_refid')
            ->maxLength('audio_refid', 20)
            ->allowEmptyString('audio_refid')
            ->add('audio_refid', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['audio_refid']));

        return $rules;
    }

    public function findMusic(Query $query, array $options)
    {
        $query = $query->where(['Videos.video_type' => 'music']);
//        if (!empty($options)) {
//            $query = $query->applyOptions($options);
//        }
        return $query;
    }


    /**
     * Organize results into three categories of unread, recent and older
     *
     * @param Query|null $query
     * @return Query
     */
    public function categorize(Query $query = null)
    {
        if (!$query) {
            $query = $this->find();
        }
        $query = $query->andWhere(function (QueryExpression $exp, Query $q) {
            return $exp->addCase(
                [
                    //  Unread notifications
                    $q->newExpr()->eq('Notifications.is_read', 0),

                    // Created between now and 4 days back, that has been read
                    $q->newExpr()->between(
                        'Notifications.created',
                        new \DateTime('now'),
                        new \DateTime('-4 days')
                    ),

                    // Older than 4 days back
                    $q->newExpr()->lt('Notifications.created', new \DateTime('-4 days'))
                ],
                ['unread', 'recent', 'older'],
                ['string', 'string', 'string']
            );
        });

        return $query;
    }


}
