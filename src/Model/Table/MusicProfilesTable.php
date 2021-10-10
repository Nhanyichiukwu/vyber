<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MusicProfiles Model
 *
 * @method \App\Model\Entity\MusicProfile get($primaryKey, $options = [])
 * @method \App\Model\Entity\MusicProfile newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MusicProfile[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MusicProfile|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MusicProfile|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MusicProfile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MusicProfile[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MusicProfile findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MusicProfilesTable extends Table
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

        $this->setTable('music_profiles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users');
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
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('user_refid')
            ->maxLength('user_refid', 20)
            ->requirePresence('user_refid', 'create')
            ->allowEmptyString('user_refid', null);

        $validator
            ->scalar('role_refid')
            ->maxLength('role_refid', 20)
            ->allowEmptyString('role_refid');

        $validator
            ->scalar('celebrity_name')
            ->maxLength('celebrity_name', 255)
            ->allowEmptyString('celebrity_name');

        $validator
            ->scalar('user_entity_refid')
            ->maxLength('user_entity_refid', 20)
            ->allowEmptyString('user_entity_refid');

        $validator
            ->scalar('genre_refid')
            ->maxLength('genre_refid', 20)
            ->allowEmptyString('genre_refid');

        $validator
            ->scalar('music_categories')
            ->allowEmptyString('music_categories');

        $validator
            ->date('debut')
            ->allowEmptyDate('debut');

        $validator
            ->scalar('debut_album')
            ->maxLength('debut_album', 20)
            ->allowEmptyString('debut_album');

        $validator
            ->scalar('debut_song')
            ->maxLength('debut_song', 20)
            ->allowEmptyString('debut_song');

        $validator
            ->nonNegativeInteger('number_of_songs')
            ->allowEmptyString('number_of_songs');

        $validator
            ->nonNegativeInteger('number_of_videos')
            ->allowEmptyString('number_of_videos');

        $validator
            ->nonNegativeInteger('number_of_albums')
            ->allowEmptyString('number_of_albums');

        $validator
            ->nonNegativeInteger('number_of_features')
            ->allowEmptyString('number_of_features');

        $validator
            ->scalar('story')
            ->allowEmptyString('story');

        $validator
            ->scalar('manager')
            ->maxLength('manager', 255)
            ->allowEmptyString('manager');

        return $validator;
    }
}
