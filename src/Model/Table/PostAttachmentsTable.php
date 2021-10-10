<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use App\Model\Table\AppTable;
use Cake\Validation\Validator;

/**
 * PostAttachments Model
 *
 * @method \App\Model\Entity\PostAttachment get($primaryKey, $options = [])
 * @method \App\Model\Entity\PostAttachment newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PostAttachment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PostAttachment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PostAttachment|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PostAttachment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PostAttachment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PostAttachment findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PostAttachmentsTable extends AppTable
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

        $this->setTable('post_attachments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Posts', [
            'foreignKey' => 'post_refid',
            'className' => 's'
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
            ->scalar('post_refid')
            ->maxLength('post_refid', 20)
            ->requirePresence('post_refid', 'create')
            ->allowEmptyString('post_refid', null);

        $validator
            ->scalar('author_refid')
            ->maxLength('author_refid', 20)
            ->requirePresence('author_refid', 'create')
            ->allowEmptyString('author_refid', null);

        $validator
            ->scalar('attachment_type')
            ->requirePresence('attachment_type', 'create')
            ->allowEmptyString('attachment_type', null);

        $validator
            ->scalar('attachment_refid')
            ->maxLength('attachment_refid', 20)
            ->allowEmptyString('attachment_refid');

        $validator
            ->scalar('file_path')
            ->maxLength('file_path', 255)
            ->allowEmptyString('file_path');

        $validator
            ->scalar('permalink')
            ->maxLength('permalink', 1000)
            ->requirePresence('permalink', 'create')
            ->allowEmptyString('permalink', null);

        $validator
            ->scalar('attachment_description')
            ->maxLength('attachment_description', 255)
            ->allowEmptyString('attachment_description');

        $validator
            ->scalar('attachment_tags')
            ->allowEmptyString('attachment_tags');

        return $validator;
    }
}
