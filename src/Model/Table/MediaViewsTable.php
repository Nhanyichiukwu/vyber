<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MediaViews Model
 *
 * @method \App\Model\Entity\MediaView get($primaryKey, $options = [])
 * @method \App\Model\Entity\MediaView newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MediaView[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MediaView|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MediaView|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MediaView patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MediaView[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MediaView findOrCreate($search, callable $callback = null, $options = [])
 */
class MediaViewsTable extends Table
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

        $this->setTable('media_views');
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
            ->scalar('media_refid')
            ->maxLength('media_refid', 20)
            ->requirePresence('media_refid', 'create')
            ->allowEmptyString('media_refid', null);

        $validator
            ->scalar('viewer_refid')
            ->maxLength('viewer_refid', 20)
            ->requirePresence('viewer_refid', 'create')
            ->allowEmptyString('viewer_refid', null);

        $validator
            ->dateTime('view_date')
            ->requirePresence('view_date', 'create')
            ->allowEmptyDateTime('view_date', null);

        $validator
            ->numeric('view_level')
            ->requirePresence('view_level', 'create')
            ->allowEmptyString('view_level', null);

        $validator
            ->scalar('playing_status')
            ->requirePresence('playing_status', 'create')
            ->allowEmptyString('playing_status', null);

        return $validator;
    }
}
