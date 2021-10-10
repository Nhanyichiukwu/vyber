<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use App\Model\Table\AppTable;
use Cake\Validation\Validator;

/**
 * Posts Model
 *
 * @property \App\Model\Table\AttachmentBatchesTable|\Cake\ORM\Association\BelongsTo $AttachmentBatches
 *
 * @method \App\Model\Entity\Post get($primaryKey, $options = [])
 * @method \App\Model\Entity\Post newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Post[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Post|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Post|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Post patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Post[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Post findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OldPostsTable extends AppTable
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('posts');
        $this->setDisplayField('refid');
        $this->setPrimaryKey('refid');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'author_refid',
            'joinType' => 'LEFT'
        ]);
        
        $this->hasMany('Comments', [
            'foreignKey' => 'post_refid',
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('Likes', [
            'foreignKey' => 'post_refid',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Newsfeeds', [
            'foreignKey' => 'author_refid',
            'joinType' => 'RIGHT'
        ]);
//        $this->hasMany('ContentShares', [
//            'foreignKey' => 'post_refid',
//            'joinType' => 'LEFT'
//        ]);
//        $this->belongsTo('Photos', [
//            'foreignKey' => 'attachment_refkey',
//            'joinType' => 'LEFT'
//        ]);
//        $this->belongsTo('Videos', [
//            'foreignKey' => 'attachment_refkey',
//            'joinType' => 'LEFT'
//        ]);
//        $this->belongsTo('Movies', [
//            'foreignKey' => 'attachment_refkey',
//            'joinType' => 'LEFT'
//        ]);
//        $this->belongsTo('Audios', [
//            'foreignKey' => 'attachment_refkey',
//            'joinType' => 'LEFT'
//        ]);
//        $this->belongsTo('Files', [
//            'foreignKey' => 'attachment_refkey',
//            'joinType' => 'LEFT'
//        ]);
////        $this->belongsToMany('Links', [
////            'foreignKey' => 'attachment_refkey',
////            'joinType' => 'LEFT'
////        ]);
//        $this->belongsTo('Achievements', [
//            'foreignKey' => 'attachment_refkey',
//            'joinType' => 'LEFT'
//        ]);
//        $this->belongsTo('Awards', [
//            'foreignKey' => 'attachment_refkey',
//            'joinType' => 'LEFT'
//        ]);
//        $this->belongsTo('Nominations', [
//            'foreignKey' => 'attachment_refkey',
//            'joinType' => 'LEFT'
//        ]);
//        $this->belongsTo('Events', [
//            'foreignKey' => 'attachment_refkey',
//            'joinType' => 'LEFT'
//        ]);
//        $this->belongsTo('Checkins', [
//            'foreignKey' => 'attachment_refkey',
//            'joinType' => 'LEFT'
//        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', true)
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('refid')
            ->maxLength('refid', 20)
            ->requirePresence('refid', 'create')
            ->allowEmptyString('refid', false);

        $validator
            ->scalar('author_refid')
            ->maxLength('author_refid', 20)
            ->requirePresence('author_refid', 'create')
            ->allowEmptyString('author_refid', false);

        $validator
            ->scalar('original_author_refid')
            ->maxLength('original_author_refid', 20)
            ->requirePresence('original_author_refid', 'create')
            ->allowEmptyString('original_author_refid', false);

        $validator
            ->scalar('post_text')
            ->allowEmptyString('post_text');

        $validator
            ->scalar('original_post_refid')
            ->maxLength('original_post_refid', 20)
            ->allowEmptyString('original_post_refid');

        $validator
            ->scalar('shared_post_refid')
            ->maxLength('shared_post_refid', 20)
            ->allowEmptyString('shared_post_refid');

        $validator
            ->scalar('shared_post_referer')
            ->maxLength('shared_post_referer', 255)
            ->allowEmptyString('shared_post_referer');

        $validator
            ->scalar('attachment_refkey')
            ->maxLength('attachment_refkey', 8)
            ->allowEmptyString('attachment_refkey');
        
        $validator
            ->scalar('type')
            ->allowEmptyString('type');

        $validator
            ->allowEmptyString('tags');

        $validator
            ->scalar('location')
            ->maxLength('location', 255)
            ->allowEmptyString('location');

        $validator
            ->scalar('privacy')
            ->allowEmptyString('privacy');

        $validator
            ->boolean('status')
            ->allowEmptyString('status');

        $validator
            ->scalar('year_published')
            ->allowEmptyString('year_published');

        $validator
            ->dateTime('date_published')
            ->allowEmptyDateTime('date_published');

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
        $rules->add($rules->isUnique(['id']));
        $rules->add($rules->existsIn('author_refid', 'Users'));
//        $rules->add($rules->existsIn('attachment_refkey', 'Photos'));
//        $rules->add($rules->existsIn('attachment_refkey', 'Videos'));
//        $rules->add($rules->existsIn('attachment_refkey', 'Audios'));
//        $rules->add($rules->existsIn('attachment_refkey', 'Files'));
//        $rules->add($rules->existsIn('attachment_refkey', 'Links'));
//        $rules->add($rules->existsIn('attachment_refkey', 'Likes'));
//        $rules->add($rules->existsIn('attachment_refkey', 'Awards'));
//        $rules->add($rules->existsIn('attachment_refkey', 'Achievements'));
//        $rules->add($rules->existsIn('attachment_refkey', 'Nominations'));
//        $rules->add($rules->existsIn('attachment_refkey', 'Checkins'));
//        $rules->add($rules->existsIn('attachment_refkey', 'Events'));

        return $rules;
    }
}
