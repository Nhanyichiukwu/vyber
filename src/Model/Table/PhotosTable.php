<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use App\Model\Table\AppTable;
use Cake\Validation\Validator;

/**
 * Photos Model
 *
 * @method \App\Model\Entity\Photo get($primaryKey, $options = [])
 * @method \App\Model\Entity\Photo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Photo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Photo|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Photo|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Photo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Photo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Photo findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PhotosTable extends AppTable
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

        $this->setTable('photos');
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
            'joinType' => 'INNER',
            'className' => 'Albums'
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
            ->allowEmptyString('id')
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('refid')
            ->maxLength('refid', 20)
            ->requirePresence('refid', 'create')
            ->allowEmptyString('refid', null);

        $validator
            ->scalar('author_refid')
            ->maxLength('author_refid', 20)
            ->requirePresence('author_refid', 'create')
            ->allowEmptyString('author_refid', null);

        $validator
            ->scalar('album_refid')
            ->maxLength('album_refid', 20)
            ->allowEmptyString('album_refid');

        $validator
            ->scalar('file_path')
            ->maxLength('file_path', 255)
            ->requirePresence('file_path', 'create')
            ->allowEmptyString('file_path', null);

        $validator
            ->scalar('location')
            ->maxLength('location', 255)
            ->allowEmptyString('location');

        $validator
            ->scalar('privacy')
            ->allowEmptyString('privacy');

        $validator
            ->scalar('tags')
            ->maxLength('tags', 255)
            ->allowEmptyString('tags');

        $validator
            ->scalar('role')
            ->allowEmptyString('role');

        $validator
            ->scalar('caption')
            ->maxLength('caption', 255)
            ->allowEmptyString('caption');

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
        $rules->add($rules->isUnique(['id']));

        return $rules;
    }

    public function findByAuthor(Query $query, array $options = [])
    {
        return $query->where(['Photos.author_refid' => $options['author']]);
    }

    public function findByPrivacy(Query $query, array $options = [])
    {
        $accessLevel = (array) $options['privacy'];
        return $query->whereInList('Photos.privacy', $accessLevel);
    }
}
