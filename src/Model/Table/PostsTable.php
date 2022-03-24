<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Behavior\CommonBehavior;
use App\Model\Entity\Post;
use App\Model\Entity\User;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\Exception\InvalidPrimaryKeyException;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validation;
use Cake\Validation\Validator;
use Cake\Collection\Collection;
use Cake\Database\Exception as DbException;

/**
 * Posts Model
 *
 * @method \App\Model\Entity\Post newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Post[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Post|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Post|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Post patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Post[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Post findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin CommonBehavior
 */
class PostsTable extends Table
{
    protected $_relationships = [
        'Authors' => ['Profiles'], // Each post contains details of the author and their profile
        'OriginalAuthors' => ['Profiles'], // Each post (where available) contains information about the original author
        'OriginalPosts' => ['Authors' => ['Profiles']],
        'Reactions' => ['Reactors' => ['Profiles']],
        'Comments' => ['Authors' => ['Profiles']],
        'Attachments'
    ];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('posts');
        $this->setDisplayField('refid');
        $this->setPrimaryKey('refid');

        $this->addBehavior('Timestamp', ['timezone' => 'GMT']);
        $this->addBehavior('Common', ['dateFormat' => [Query::class, 'Posts.date_published']]);

        $this->belongsTo('Authors', [
            'foreignKey' => 'author_refid',
            'joinType' => 'INNER',
            'className' => 'Users',
            'strategy' => 'select'
        ]);

        $this->hasOne('OriginalAuthors', [
            'foreignKey' => 'refid',
            'bindingKey' => 'original_author_refid',
            'joinType' => 'INNER',
            'className' => 'Users'
        ])->setProperty('originalAuthor');

        $this->hasOne('OriginalPosts', [
            'foreignKey' => 'refid',
            'bindingKey' => 'original_post_refid',
            'joinType' => 'LEFT',
            'className' => 'Posts'
        ])->setProperty('originalPost');

//        $this->hasMany('Comments', [
//            'foreignKey' => 'replying_to',
//            'targetForeignKey' => 'refid',
//            'joinType' => 'INNER',
//            'joinTable' => 'e_posts'
//        ]);
//        $this->belongsTo('Posts', [
//            'foreignKey' => 'replying_to',
//            'targetForeignKey' => 'refid'
//        ]);
//
        $this->belongsTo('Parents', [
            'foreignKey' => 'replying_to',
            'joinType' => 'INNER',
            'className' => 'Posts'
        ]);

        $this->hasMany('Comments', [
            'foreignKey' => 'replying_to',
            'joinType' => 'INNER',
            'className' => 'Posts'
        ])
            ->setStrategy('subquery')
            ->setProperty('comments');

//        $this->addAssociations([
//            'belongsTo' => [
//                'Posts' => [
//                    'foreignKey' => 'author_refid',
//                    'className' => 'App\Model\Table\PostsTable',
//                    'strategy' => 'subquery'
//                ]
//            ],
//            'belongsTo' => [
//                'Authors' => [
//                    'foreignKey' => 'author_refid',
//                    'className' => 'App\Model\Table\UsersTable'
//                ]
//            ],
//            'hasMany' => [
//                'Replies' => [
//                    'foreignKey' => 'refid',
//                    'bindingKey' => 'replying_to',
//                    'className' => 'Comments',
//                    'strategy' => 'subquery'
//                ]
//            ],
//            'hasMany' => [
//                'Attachments' => [
//                    'className' => 'App\Model\Table\PostAttachments'
//                ]
//            ]
//            'belongsToMany' => ['Tags']
//        ]);
//        $this->belongsTo('Commenters', [
//            'foreignKey' => 'author_refid',
//            'className' => 'Users',
//        ])
////            ->setProperty('Commenters')
//            ->setConditions(['Comments.type' => 'comment', 'Commparent_type' => 'post']);
//
//        $this->hasMany('Commenters', [
//                'foreignKey' => 'refid',
//                'className' => 'Users'
//            ])
//            ->setConditions(['type' => 'comment', 'parent_type' => 'post']);
//
//        $this->hasMany('Replies', [
//
//                ])
//                ->setClassName('Replies')
//                ->setTarget($this)
//                ->setProperty('replies')
//                ->setConditions(['Posts.type' => 'reply']);
//                ->setTarget($this);
//
//        $this->belongsTo('Repliers', [
//                'foreignKey' => 'author_refid',
//                'className' => 'Users'
//            ])
//            ->setConditions(['type' => 'reply', 'parent_type' => 'comment']);

//        $this->belongsTo('Posts', [
//            'foreignKey' => 'replying_to',
//            'targetForeignKey' => 'refid'
//        ])->setConditions(['Posts.type' => 'comment']);
//
//        $this->belongsTo('Comments', [
//            'foreignKey' => 'replying_to',
//            'targetForeignKey' => 'refid'
//        ])->setConditions(['Posts.type' => 'reply', 'Posts.parent_type' => 'comment']);

        $this->hasMany('Reactions', [
            'foreignKey' => 'content_refid',
            'className' => 'PostReactions'
        ]);

        $this->hasMany('Attachments', [
            'foreignKey' => 'post_refid',
            'className' => 'PostAttachments'
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
            ->maxLength('refid', 20)
            ->requirePresence('refid', 'create')
            ->allowEmptyString('refid', null)
            ->add('refid', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('author_refid')
            ->maxLength('author_refid', 20)
            ->requirePresence('author_refid', 'create')
            ->allowEmptyString('author_refid', null);

        $validator
            ->scalar('original_author_refid')
            ->maxLength('original_author_refid', 20)
            ->requirePresence('original_author_refid', 'create')
            ->allowEmptyString('original_author_refid', null);

        $validator
            ->scalar('type')
            ->requirePresence('type', 'create')
            ->allowEmptyString('type', null);

        $validator
            ->scalar('replying_to')
            ->maxLength('replying_to', 20)
            ->allowEmptyString('replying_to');

        $validator
            ->scalar('parent_type')
            ->allowEmptyString('parent_type');

        $validator
            ->scalar('post_text')
            ->allowEmptyString('post_text');

        $validator
            ->boolean('copied')
            ->allowEmptyString('copied');

        $validator
            ->scalar('copied_as')
            ->allowEmptyString('copied_as');

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
            ->scalar('tags')
            ->maxLength('tags', 16777215)
            ->allowEmptyString('tags');

        $validator
            ->scalar('location')
            ->maxLength('location', 255)
            ->allowEmptyString('location');

        $validator
            ->scalar('privacy')
            ->allowEmptyString('privacy');

        $validator
            ->scalar('status')
            ->allowEmptyString('status');

        $validator
            ->dateTime('date_published')
            ->allowEmptyDateTime('date_published');

        return $validator;
    }


//    public function findAll($query, $options) {
//        $query = $this->dateFormat($query, 'Posts.date_published');
//        $query = $query->addDefaultTypes($this);
//        $query = parent::findAll($query, $options);
//
//        return $query;
//    }

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

    public function findRecent(Query $query, array $options = null)
    {
        $query = $query
            ->where(['Posts.status' => 'published'])
            ->orderDesc('Posts.date_published');
        if (isset($options['author'])) {
            $author = $options['author'];
            if (is_string($author) && $author !== 'any') {
                $query = $query->where(['Posts.author_refid' => $author]);
            } elseif ($author instanceof User) {
                $query = $query->where(['Posts.author_refid' => $author->refid]);
            }
        }
        if (!count($query->getContain())) {
            $query = $query->contain($this->_relationships);
        }
        
        $query = $this->dateFormat($query, 'Posts.date_published');
        return $query;
    }
    
    /**
     * 
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findBasicThreads(Query $query, array $options): Query
    {
        $user = $options['user'];
        $userID = $user instanceof User ? $user->refid : $user;
        
        /** @var \App\Model\Table\UsersTable $AuthorsAssoc **/
        $AuthorsAssoc = $this->getAssociation('Authors')
                ->getTarget()
                ->setAlias('Users');
        $feedSources = $AuthorsAssoc->find('userFeedSources', ['user' => $userID]);
        
        $query = $query->where([
                            'OR' => [
                                'Posts.author_refid IN' => $feedSources,
                                'Posts.author_refid' => $userID
                            ]
                        ])
                        ->contain($this->_relationships);
        return $this->dateFormat($query, 'Posts.date_published');
    }
    
    
    public function findLiveThreads(Query $query, array $options = []) {
        
        
        return $query;
    }

    /**
     * Returns a list of posts as thread in a parent-children hierarchy
     *
     * @param array $conditions Use the conditions to apply additional filters
     * @return Query
     */
    public function getAll(array $conditions = [], $nestingKey = null)
    {
        if ($nestingKey === null) {
            $nestingKey = 'comments';
        }

//        $query = $this->find('threaded', [
//            'keyField' => 'refid',
//            'parentField' => 'replying_to',
//            'nestingKey' => $nestingKey
//        ]);
        $query = $this->find('all')
                ->whereNull('Posts.replying_to')
                ->contain($this->_relationships);

        if ($conditions) {
            $query = $query->andWhere($conditions);
        }
        $query = $this->dateFormat($query, 'Posts.date_published');

        return $query;
    }

    public function filterByAuthor(User $actor, Query $query, string $author, $newsSources)
    {
        if ($author === 'anyone') {
            $newsSources[] = $actor->refid; // Then include the actor's posts as well
            $query = $query->whereInList('Posts.author_refid', $newsSources);
        }  elseif ($author === 'others') {
            // Posts by anyone except those of the actor
            $query = $query->whereInList('Posts.author_refid', $newsSources);
        } else {
            try {
                $query = $query->where([
                    'Posts.author_refid' => $author
                ]);
            } catch (DbException $exc) {
                echo $exc->getTraceAsString();
            }
        }

        return $query;
    }

    /**
     *
     * @param User $actor
     * @param Query $query
     * @param type $date
     * @return Query
     */
    public function filterByDate(User $actor, Query $query, $date)
    {
        $newsSources = (array) $this->getNewsSources($actor->get('refid'));
        $newsSources[] = $actor->refid; // Then include the actor posts as well
        $query = $query->whereInList('Posts.author_refid', $newsSources);

        $validation = new Validation();
        if (false !== $validation->date($date, ['ymd', 'dmy', 'mdy'])) {
            $query = $query->where(['Posts.date_published' => $date]);
        }

        return $query;
    }

    public function filterByRelevance(Query $query, array $options)
    {

        return $query;
    }


    public function getPostsBy($author)
    {
        $posts = $this->findByAuthor($author)
                ->orderDesc('Posts.id')
                ->groupBy('year')
                ->toArray();

        return $posts;
    }

    /**
     * Fetch all posts by a given user
     *
     * @param Query $query
     * @param string|object $author
     * @return Query
     */
    public function findByAuthor(Query $query, array $options)
    {
        $author = $options['author'];

        if (is_string($author)) {
            $authorID = $author;
        } elseif ($author instanceof User) {
            $authorID = $author->refid;
        } else {
            $msg = 'Posts::findByAuthor() requires the author option ' .
                'provided in the $options argument to be either of type string ' .
                'or object of the User entity.';
            throw new \InvalidArgumentException($msg);
        }
        $query = $query
            ->where(['Posts.author_refid' => $authorID]);
        if (!count($query->getContain())) {
            $query = $query->contain($this->_relationships);
        }
//        $result = $query->map(function ($row) {
//            $row->set('comments', $this->getDescendants($row->refid));
//            return $row;
//        });
//        $query = $this->findThreaded($query, []);
        $query = $this->dateFormat($query, 'Posts.date_published');

        return $query;
    }

    /**
     * Get a single post by primaryKey, including all possible association
     * This will also run a sub-query to fetch the any comments/replies
     * associated to this
     *
     * @param string $refid The primaryKey of the post
     * @param array $conditions The conditions by which to filter the query
     * @return \App\Model\Entity\Post The first result from the results
     * @throws RecordNotFoundException
     */
    public function getByRefid($refid, $conditions = [])
    {
        $options = [
            'conditions' => ['Posts.refid' => $refid],
            'contain' => $this->_relationships
        ];
        if (!empty($conditions)) {
            $options['conditions'] = array_merge($options['conditions'], $conditions);
        }

        $post = $this->get($refid, $options);

//        $query = $this->dateFormat($query, 'Posts.date_published');
//        $post = $query->firstOrFail();

        /* @var $comments \Cake\ORM\ResultSet */
        $comments = $this->getDescendants($post->refid);

        $post->set('comments', $comments);

        return $post;
    }

    /**
     * @param mixed $primaryKey
     * @param array $options
     * @return Post|\Cake\Datasource\EntityInterface
     * @throws RecordNotFoundException
     */
    public function get($primaryKey, array $options = []): EntityInterface
    {
        if (!isset($options['contain'])) {
            $options['contain'] = $this->_relationships;
        }
        try {
            $post = parent::get($primaryKey, $options);
        } catch (InvalidPrimaryKeyException $exception) {
            throw new RecordNotFoundException($exception->getMessage());
        } catch (\Exception $exception) {
            throw new RecordNotFoundException($exception->getMessage());
        }

        return $post;
    }

    /**
     * Fetch all descendants of a given post/comment, identified by the refid
     *
     * @param string $parent
     * @return array
     */
    public function getDescendants(string $parent)
    {
        $query = $this->find()
                ->contain($this->_relationships)
                ->where(['Posts.replying_to' => $parent]);
        $query = $this->dateFormat($query, 'Posts.date_published');
        $query = $query->orderAsc('Posts.id');
        $resultSet = $query->each(function ($post) {
            $post->set('replies', []);
            if (!$this->exists(['replying_to' => $post->refid])) {
                return $post;
            }

            $descendants = $this->getDescendants($post->refid);
            $post->set('replies', $descendants);

            return $post;
        });
        $result = $resultSet->toArray();
//        $descendants = $this->containParents($result);
        return $result;
    }

    public function getParent($parentRefid) {
        if (!$this->exists(['Posts.type' => $parentRefid])) {
            return null;
        }
        $parent = $this->find('all')->where(['Posts.type' => $parentRefid])->first();

        return $parent;
    }

    public function containParents(array $children) 
    {
        $collection = new Collection($children);
        $children = $collection->each(function ($child) {
            if (!$child->isEmpty('replying_to')) {
                $child->set('parent', $this->getParent($child->replying_to));
            }
            return $child;
        });

        return $children->toArray();
    }
    
}
