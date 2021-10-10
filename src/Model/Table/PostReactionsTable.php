<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\PostReaction;
use Cake\Database\Exception;
use Cake\Log\Log;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PostReactions Model
 *
 * @method \App\Model\Entity\PostReaction get($primaryKey, $options = [])
 * @method \App\Model\Entity\PostReaction newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PostReaction[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PostReaction|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PostReaction|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PostReaction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PostReaction[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PostReaction findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PostReactionsTable extends Table
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

        $this->setTable('post_reactions');
        $this->setDisplayField('refid');
        $this->setPrimaryKey('refid');

        $this->addBehavior('Timestamp');

        $this->belongsTo('s', [
            'foreignKey' => 'content_refid',
            'joinType' => 'INNER'
        ]);
        $this->hasOne('Reactors', [
            'foreignKey' => 'refid',
            'bindingKey' => 'reactor_refid',
            'className' => 'Users'
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
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('refid')
            ->maxLength('refid', 20)
            ->requirePresence('refid', 'create')
            ->allowEmptyString('refid', null);

        $validator
            ->scalar('name')
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', null);

        $validator
            ->scalar('content_refid')
            ->maxLength('content_refid', 20)
            ->requirePresence('content_refid', 'create')
            ->allowEmptyString('content_refid', null);

        $validator
            ->scalar('content_type')
            ->maxLength('content_type', 45)
            ->requirePresence('content_type', 'create')
            ->allowEmptyString('content_type', null);

        $validator
            ->scalar('reactor_refid')
            ->maxLength('reactor_refid', 20)
            ->requirePresence('reactor_refid', 'create')
            ->allowEmptyString('reactor_refid', null);

        return $validator;
    }

    public function alreadyExists(string $actor, $contentRefid, $contentType)
    {
        return $this->exists([
            'reactor_refid' => $actor,
            'content_refid' => $contentRefid,
            'content_type' => $contentType
        ]);
    }

    public function undo(string $actor, $contentRefid, $contentType)
    {
        if ($this->alreadyExists($actor, $contentRefid, $contentType)) {
            $reaction = $this->find()->where([
                'reactor_refid' => $actor,
                'content_refid' => $contentRefid,
                'content_type' => $contentType
            ])->first();

            if ($reaction instanceof PostReaction) {
                try {
                    $this->delete($reaction);
                } catch (Exception $exc) {
                    Log::error($exc->getMessage());
                    return false;
                }
                return true;
            }
        }
    }


}
