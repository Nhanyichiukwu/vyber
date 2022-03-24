<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class All extends AbstractMigration
{
    public $autoId = false;

    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
     * @return void
     */
    public function up()
    {
        $this->table('achievements')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('refkey', 'string', [
                'default' => null,
                'limit' => 8,
                'null' => false,
            ])
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('date', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('assisted_by', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'user_refid',
                ]
            )
            ->addIndex(
                [
                    'id',
                ]
            )
            ->create();

        $this->table('activities')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('activity_type_id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('activity_subject_id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('actor_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'activity_type_id',
                ]
            )
            ->addIndex(
                [
                    'actor_refid',
                ]
            )
            ->addIndex(
                [
                    'activity_subject_id',
                ]
            )
            ->create();

        $this->table('activity_subjects')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('activity_types')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('albums')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('owner_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('media_type', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('counterpart', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('release_date', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('is_debut', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('privacy', 'string', [
                'default' => 'private',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('published', 'boolean', [
                'default' => true,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('mofified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'slug',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'id',
                ]
            )
            ->create();

        $this->table('audios')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('cast', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('tags', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('author_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('genre_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('album_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('author_location', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('categories', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('url', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('file_mime_type', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('audio_type', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('video_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('release_date', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('privacy', 'string', [
                'default' => 'private',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('status', 'string', [
                'default' => 'published',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_debut', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('monetize', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('language', 'text', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('orientation', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('thumbnail', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('total_plays', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('number_of_people_played', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('number_of_downloads', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'video_refid',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'id',
                ]
            )
            ->addIndex(
                [
                    'album_refid',
                ]
            )
            ->addIndex(
                [
                    'author_refid',
                ]
            )
            ->addIndex(
                [
                    'genre_refid',
                ]
            )
            ->create();

        $this->table('awards')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('refkey', 'string', [
                'default' => null,
                'limit' => 8,
                'null' => false,
            ])
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('date', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('awarded_by', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('subject', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'user_refid',
                ]
            )
            ->addIndex(
                [
                    'id',
                ]
            )
            ->create();

        $this->table('categories')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('parent_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('type_id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('thumbnail', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('views', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'type_id',
                ]
            )
            ->addIndex(
                [
                    'parent_refid',
                ]
            )
            ->addIndex(
                [
                    'id',
                ]
            )
            ->create();

        $this->table('category_items')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('category_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('item_foreign_key', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('item_table_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('item_type', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('date_added', 'datetime', [
                'default' => '0000-00-00 00:00:00',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'category_refid',
                ]
            )
            ->create();

        $this->table('category_types')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('causes')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'id',
                ]
            )
            ->create();

        $this->table('chat_correspondents')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('chat_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('correspondents', 'binary', [
                'default' => null,
                'limit' => 4294967295,
                'null' => false,
            ])
            ->addIndex(
                [
                    'chat_refid',
                ]
            )
            ->create();

        $this->table('chat_participants')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('chat_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('participant_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('added_by', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('date_added', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_admin', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('previously_engaged_in', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'chat_refid',
                ]
            )
            ->addIndex(
                [
                    'participant_refid',
                ]
            )
            ->addIndex(
                [
                    'added_by',
                ]
            )
            ->create();

        $this->table('chats')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('initiator_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('start_time', 'datetime', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('last_active_time', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('last_active_participant_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('chattype', 'string', [
                'default' => 'interpersonal',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('avatar', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('group_accessibility', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('group_scalability', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('max_participants', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'id',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'initiator_refid',
                ]
            )
            ->create();

        $this->table('comedians_profiles')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('role_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('popular_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('debut', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('debut_movie', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('number_of_movies', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('skills', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('instruments_known', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('spoken_languages', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('story', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('manager', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('debut_movie_role', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addIndex(
                [
                    'user_refid',
                ]
            )
            ->addIndex(
                [
                    'role_refid',
                ]
            )
            ->create();

        $this->table('comments')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('author_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('post_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('in_reply_to', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('text', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('has_attachment', 'string', [
                'default' => '0',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('attachments', 'binary', [
                'default' => null,
                'limit' => 4294967295,
                'null' => true,
            ])
            ->addColumn('type', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('tags', 'binary', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('location', 'text', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('privacy', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('status', 'string', [
                'default' => 'published',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'id',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'author_refid',
                ]
            )
            ->addIndex(
                [
                    'post_refid',
                ]
            )
            ->addIndex(
                [
                    'text',
                ],
                ['type' => 'fulltext']
            )
            ->create();

        $this->table('connections')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('correspondent_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'correspondent_refid',
                ]
            )
            ->addIndex(
                [
                    'user_refid',
                ]
            )
            ->create();

        $this->table('conversations')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('chat_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('message_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('sender_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('recipient_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('is_read', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('is_trashed', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('flag', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('archived', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('message_time', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'id',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'chat_refid',
                ]
            )
            ->addIndex(
                [
                    'sender_refid',
                ]
            )
            ->addIndex(
                [
                    'recipient_refid',
                ]
            )
            ->addIndex(
                [
                    'message_refid',
                ]
            )
            ->create();

        $this->table('e_news')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('body', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('author_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('status', 'string', [
                'default' => 'published',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('privacy', 'string', [
                'default' => 'public',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'slug',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'author_refid',
                ]
            )
            ->addIndex(
                [
                    'id',
                ]
            )
            ->addIndex(
                [
                    'title',
                    'body',
                ],
                ['type' => 'fulltext']
            )
            ->create();

        $this->table('emails')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('address', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('is_primary', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('type', 'string', [
                'default' => 'personal',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'address',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('event_guests')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('event_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('event_venue_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('guest_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('inviter_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('date_invited', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('event_seen', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('date_seen', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('invite_response_date', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('response', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('event_status', 'string', [
                'default' => 'active',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'event_venue_id',
                ]
            )
            ->addIndex(
                [
                    'guest_refid',
                ]
            )
            ->addIndex(
                [
                    'inviter_refid',
                ]
            )
            ->addIndex(
                [
                    'event_refid',
                ]
            )
            ->create();

        $this->table('event_invitees')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('event_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('event_venue_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('guest_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('inviter_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('date_invited', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('event_seen', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('date_seen', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('invite_response_date', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('response', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('event_status', 'string', [
                'default' => 'active',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'guest_refid',
                ]
            )
            ->addIndex(
                [
                    'event_refid',
                ]
            )
            ->addIndex(
                [
                    'event_venue_id',
                ]
            )
            ->addIndex(
                [
                    'inviter_refid',
                ]
            )
            ->create();

        $this->table('event_types')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('event_venues')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('event_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('image', 'binary', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('country_region', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('state_province', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('city', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('address', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('start_date', 'datetime', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('end_date', 'datetime', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('status', 'string', [
                'default' => 'draft',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'event_refid',
                ]
            )
            ->addIndex(
                [
                    'description',
                ],
                ['type' => 'fulltext']
            )
            ->addIndex(
                [
                    'address',
                ],
                ['type' => 'fulltext']
            )
            ->create();

        $this->table('events')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('event_type_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('privacy', 'string', [
                'default' => 'private',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('image', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('host_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('status', 'string', [
                'default' => 'published',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => '0000-00-00 00:00:00',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => '0000-00-00 00:00:00',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'user_refid',
                ]
            )
            ->addIndex(
                [
                    'id',
                ]
            )
            ->addIndex(
                [
                    'event_type_id',
                ]
            )
            ->addIndex(
                [
                    'description',
                ],
                ['type' => 'fulltext']
            )
            ->create();

        $this->table('follows')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('follower_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('followee_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'followee_refid',
                ]
            )
            ->addIndex(
                [
                    'follower_refid',
                ]
            )
            ->create();

        $this->table('foundations')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('short_description', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('full_description', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('mission_statement', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('vision_statement', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('founder', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('workers', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('board', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('founded', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'id',
                ]
            )
            ->create();

        $this->table('genres')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('parent_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('industry_id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'industry_id',
                ]
            )
            ->addIndex(
                [
                    'parent_refid',
                ]
            )
            ->addIndex(
                [
                    'id',
                ]
            )
            ->create();

        $this->table('group_invites')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('group_id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('sender_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('invitee_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('status', 'string', [
                'default' => 'pending',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'sender_refid',
                ]
            )
            ->addIndex(
                [
                    'group_id',
                ]
            )
            ->addIndex(
                [
                    'invitee_refid',
                ]
            )
            ->create();

        $this->table('group_join_requests')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('group_id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('status', 'string', [
                'default' => 'pending',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('message', 'text', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('appeal', 'text', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('approved_by', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('approved_at', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'group_id',
                ]
            )
            ->addIndex(
                [
                    'user_refid',
                ]
            )
            ->create();

        $this->table('group_medias')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('group_id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('media_path', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'user_refid',
                ]
            )
            ->addIndex(
                [
                    'group_id',
                ]
            )
            ->create();

        $this->table('group_members')
            ->addColumn('group_id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('invited_by', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => 'active',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('invited_at', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('approved_by', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('approved_at', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('is_admin', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'user_refid',
                ]
            )
            ->addIndex(
                [
                    'group_id',
                ]
            )
            ->addIndex(
                [
                    'approved_by',
                ]
            )
            ->addIndex(
                [
                    'invited_by',
                ]
            )
            ->create();

        $this->table('group_posts')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('group_id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('post_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('post_type', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'user_refid',
                ]
            )
            ->addIndex(
                [
                    'group_id',
                ]
            )
            ->addIndex(
                [
                    'post_refid',
                ]
            )
            ->create();

        $this->table('groups')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('group_image', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('author', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'author',
                ]
            )
            ->create();

        $this->table('guests')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('registered_user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('ip', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('device', 'string', [
                'comment' => 'Possible values: mobile, tablet, desktop',
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('browser', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('os', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('city', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('state', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('region', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('country', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('country_code', 'string', [
                'default' => null,
                'limit' => 5,
                'null' => true,
            ])
            ->addColumn('continent', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('continent_code', 'string', [
                'default' => null,
                'limit' => 2,
                'null' => true,
            ])
            ->addColumn('currency_symbol', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('currency_code', 'string', [
                'default' => null,
                'limit' => 5,
                'null' => true,
            ])
            ->addColumn('currencey_converter', 'float', [
                'default' => '0',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('timezone', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('longitude', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('latitude', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('last_visit', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('hall_of_famers')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('status', 'string', [
                'default' => 'active',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'user_refid',
                ]
            )
            ->create();

        $this->table('industries')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('parent_id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'parent_id',
                ]
            )
            ->create();

        $this->table('media_views')
            ->addColumn('media_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('viewer_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('view_date', 'datetime', [
                'default' => '0000-00-00 00:00:00',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('view_level', 'float', [
                'comment' => 'Records whether the media was played to the end or stopped halfway through.',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('playing_status', 'string', [
                'comment' => 'The current state of the media, whether it is currently being played or not.',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'viewer_refid',
                ]
            )
            ->addIndex(
                [
                    'media_refid',
                ]
            )
            ->create();

        $this->table('medias')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('cast', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('tags', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('author_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('genre_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('album_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('author_location', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('categories', 'binary', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('file_path', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('file_mime', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('media_type', 'string', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('classification', 'string', [
                'comment' => 'Specifies what kind of entertainment this media is: movie, music_video, comedy, song, etc',
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addColumn('target_audience', 'string', [
                'default' => 'both',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('audience_locations', 'text', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('age_restriction', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('audio_or_video_counterpart_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('recording_date', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('release_date', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('privacy', 'string', [
                'default' => 'public',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => 'draft',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('is_debut', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('monetize', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('language', 'string', [
                'default' => 'English',
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('orientation', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('thumbnail', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('total_plays', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('number_of_people_played', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('number_of_downloads', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'id',
                ]
            )
            ->addIndex(
                [
                    'album_refid',
                ]
            )
            ->addIndex(
                [
                    'author_refid',
                ]
            )
            ->addIndex(
                [
                    'genre_refid',
                ]
            )
            ->create();

        $this->table('messages')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('chat_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('author_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('author_ip', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('author_location', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('text', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('original_message_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('has_attachment', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('message_time', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_seen', 'string', [
                'default' => 'no',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('is_read', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('is_reply', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'chat_refid',
                ]
            )
            ->addIndex(
                [
                    'author_refid',
                ]
            )
            ->addIndex(
                [
                    'refid',
                ]
            )
            ->addIndex(
                [
                    'original_message_refid',
                ]
            )
            ->create();

        $this->table('movie_makers_profiles')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('role_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('popular_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('debut', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('debut_movie', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('number_of_movies', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('skills', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('instruments_known', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('spoken_languages', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('story', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('manager', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('debut_movie_role', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addIndex(
                [
                    'user_refid',
                ]
            )
            ->addIndex(
                [
                    'role_refid',
                ]
            )
            ->create();

        $this->table('movie_stars')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('role_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('popular_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('debut', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('debut_movie', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('number_of_movies', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('skills', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('instruments_known', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('spoken_languages', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('story', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('manager', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('debut_movie_role', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addIndex(
                [
                    'user_refid',
                ]
            )
            ->addIndex(
                [
                    'role_refid',
                ]
            )
            ->create();

        $this->table('music_categories')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'id',
                ]
            )
            ->create();

        $this->table('music_profiles')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('celebrity_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('user_entity_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('genre_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('music_categories', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('debut', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('debut_album', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('debut_song', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('number_of_songs', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('number_of_videos', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('number_of_albums', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('number_of_features', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('story', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('manager', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'user_refid',
                ]
            )
            ->addIndex(
                [
                    'genre_refid',
                ]
            )
            ->create();

        $this->table('musical_instruments')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('newsfeeds')
            ->addColumn('feed_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['feed_refid'])
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('content_type', 'string', [
                'default' => 'all',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'id',
                ]
            )
            ->addIndex(
                [
                    'user_refid',
                ]
            )
            ->create();

        $this->table('nominations')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('refkey', 'string', [
                'default' => null,
                'limit' => 8,
                'null' => false,
            ])
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('date', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('nominated_by', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'user_refid',
                ]
            )
            ->addIndex(
                [
                    'id',
                ]
            )
            ->create();

        $this->table('notifications')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('type', 'string', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('initiator_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('subject_source', 'string', [
                'comment' => 'The database table where the subject can be found',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('subject_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('subject_permalink', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('message', 'text', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('is_read', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => '0000-00-00 00:00:00',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => '0000-00-00 00:00:00',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'id',
                ]
            )
            ->addIndex(
                [
                    'initiator_refid',
                ]
            )
            ->addIndex(
                [
                    'user_refid',
                ]
            )
            ->addIndex(
                [
                    'subject_refid',
                ]
            )
            ->create();

        $this->table('phones')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('number', 'string', [
                'default' => null,
                'limit' => 14,
                'null' => false,
            ])
            ->addColumn('is_primary', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('type', 'string', [
                'default' => 'mobile',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'number',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('photos')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('author_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('album_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('file_path', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('location', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('privacy', 'string', [
                'default' => 'public',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('tags', 'text', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('role', 'string', [
                'default' => 'default',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('caption', 'text', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'id',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'author_refid',
                ]
            )
            ->addIndex(
                [
                    'album_refid',
                ]
            )
            ->create();

        $this->table('playlist_items')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('playlist_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('media_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('playlists')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('owner_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('type', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('release_date', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('privacy', 'string', [
                'default' => 'private',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('published', 'boolean', [
                'default' => true,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('mofified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'slug',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'id',
                ]
            )
            ->create();

        $this->table('post_attachments')
            ->addColumn('id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('post_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('author_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('attachment_type', 'string', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('attachment_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('file_path', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('permalink', 'string', [
                'default' => null,
                'limit' => 1000,
                'null' => false,
            ])
            ->addColumn('attachment_description', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('attachment_tags', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'post_refid',
                ]
            )
            ->addIndex(
                [
                    'author_refid',
                ]
            )
            ->create();

        $this->table('post_reactions')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('content_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('content_type', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('reactor_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'id',
                ]
            )
            ->addIndex(
                [
                    'content_refid',
                ]
            )
            ->addIndex(
                [
                    'reactor_refid',
                ]
            )
            ->create();

        $this->table('posts')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('author_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('original_author_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('type', 'string', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('category', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('topics', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('replying_to', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('parent_type', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('post_text', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('copied', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('copied_as', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('original_post_refid', 'string', [
                'comment' => 'If a post is shared or re-shared, this field will hold the refid of the original post that is being re-shared...',
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('shared_post_refid', 'string', [
                'comment' => 'If this post is a shared post, the refid of the particular post (not the original post) is saved in this field',
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('shared_post_referer', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('tags', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('location', 'text', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('privacy', 'string', [
                'default' => 'public',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => 'published',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('date_published', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => '0000-00-00 00:00:00',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => '0000-00-00 00:00:00',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'id',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'author_refid',
                ]
            )
            ->addIndex(
                [
                    'original_post_refid',
                ]
            )
            ->addIndex(
                [
                    'replying_to',
                ]
            )
            ->addIndex(
                [
                    'type',
                ]
            )
            ->addIndex(
                [
                    'parent_type',
                ]
            )
            ->addIndex(
                [
                    'post_text',
                ],
                ['type' => 'fulltext']
            )
            ->create();

        $this->table('profiles')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('about', 'text', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('country_of_origin', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('state_of_origin', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addColumn('lga_of_origin', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => true,
            ])
            ->addColumn('hometown', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => true,
            ])
            ->addColumn('country_of_residence', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('state_of_residence', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('lga_of_residence', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('current_city', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('address', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('postcode', 'string', [
                'default' => null,
                'limit' => 6,
                'null' => true,
            ])
            ->addColumn('location', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('website', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('skills', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('languages', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('profile_image_url', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('header_image_url', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'user_refid',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'user_refid',
                ]
            )
            ->addIndex(
                [
                    'about',
                ],
                ['type' => 'fulltext']
            )
            ->addIndex(
                [
                    'country_of_residence',
                ],
                ['type' => 'fulltext']
            )
            ->create();

        $this->table('promoted_contents')
            ->addColumn('id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('content_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('promoter_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('content_type', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('content_repository', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('published', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => 'active',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('audience_age_bracket', 'string', [
                'default' => '18_and_above',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('audience_gender', 'string', [
                'default' => 'both',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('audience_locations', 'text', [
                'default' => null,
                'limit' => 4294967295,
                'null' => true,
            ])
            ->addColumn('start_date', 'datetime', [
                'default' => '0000-00-00 00:00:00',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('end_date', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('budget_currency', 'string', [
                'default' => 'USD',
                'limit' => 5,
                'null' => true,
            ])
            ->addColumn('budget_amount', 'float', [
                'default' => '0',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'content_refid',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'promoter_refid',
                ]
            )
            ->create();

        $this->table('requests')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('sender_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('recipient_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('suggested_user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('proposed_meeting_date', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('proposed_meeting_time', 'time', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('short_message', 'string', [
                'default' => null,
                'limit' => 160,
                'null' => true,
            ])
            ->addColumn('is_read', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('type', 'string', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'recipient_refid',
                ]
            )
            ->addIndex(
                [
                    'sender_refid',
                ]
            )
            ->addIndex(
                [
                    'suggested_user_refid',
                ]
            )
            ->addIndex(
                [
                    'refid',
                ]
            )
            ->create();

        $this->table('roles')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('aka', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('parent_id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('industry_id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'industry_id',
                ]
            )
            ->addIndex(
                [
                    'parent_id',
                ]
            )
            ->create();

        $this->table('series')
            ->addColumn('id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('shows_profiles')
            ->addColumn('id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('type', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('popular_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('debut', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('story', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('manager', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'user_refid',
                ]
            )
            ->create();

        $this->table('subscriptions')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('subscriber_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('subscribed_to', 'string', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('content_id', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('options', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'subscriber_refid',
                ]
            )
            ->create();

        $this->table('tags')
            ->addColumn('id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('added_by', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('talent_hub')
            ->addColumn('id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('talent_id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('industry_id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('series_id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('index_in_series', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('video_path', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('video_mimetype', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('video_size', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addIndex(
                [
                    'industry_id',
                ]
            )
            ->addIndex(
                [
                    'series_id',
                ]
            )
            ->addIndex(
                [
                    'talent_id',
                ]
            )
            ->addIndex(
                [
                    'user_refid',
                ]
            )
            ->create();

        $this->table('talents')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('unique_attributes')
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('attributes', 'text', [
                'default' => null,
                'limit' => 4294967295,
                'null' => false,
            ])
            ->addIndex(
                [
                    'user_refid',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('user_entities')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'id',
                ]
            )
            ->create();

        $this->table('user_genres')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('profile_id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('genre_id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'genre_id',
                ]
            )
            ->addIndex(
                [
                    'profile_id',
                ]
            )
            ->create();

        $this->table('user_industries')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('profile_id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('industry_id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'industry_id',
                ]
            )
            ->addIndex(
                [
                    'profile_id',
                ]
            )
            ->create();

        $this->table('user_interests')
            ->addColumn('id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('object_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('object_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'user_refid',
                ]
            )
            ->create();

        $this->table('user_preferences')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('option', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('preference', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('user_properties')
            ->addColumn('role_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('firstname', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('othernames', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('lastname', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('gender', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('about', 'text', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('date_of_birth', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('country_of_origin', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('state_of_origin', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addColumn('lga_of_origin', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => true,
            ])
            ->addColumn('hometown', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => true,
            ])
            ->addColumn('country_of_residence', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('state_of_residence', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('lga_of_residence', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('current_city', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('address', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('postcode', 'string', [
                'default' => null,
                'limit' => 6,
                'null' => true,
            ])
            ->addColumn('location', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('website', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('profile_image_url', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('header_image_url', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('niche', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('account_type', 'string', [
                'default' => 'personal',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('account_status', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('time_zone', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('last_login', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'about',
                ],
                ['type' => 'fulltext']
            )
            ->create();

        $this->table('user_roles')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('profile_id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('role_id', 'biginteger', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'profile_id',
                ]
            )
            ->addIndex(
                [
                    'role_id',
                ]
            )
            ->create();

        $this->table('users')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('firstname', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('othernames', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('lastname', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 15,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('gender', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('date_of_birth', 'date', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('account_type', 'string', [
                'default' => 'regular',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('account_status', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('activated', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('is_hall_of_famer', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('time_zone', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'id',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'refid',
                    'username',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('users_ratings')
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('actor_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('rating', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('review', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'actor_refid',
                ]
            )
            ->addIndex(
                [
                    'user_refid',
                ]
            )
            ->create();

        $this->table('videos')
            ->addColumn('refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addPrimaryKey(['refid'])
            ->addColumn('id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('cast', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('tags', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('privacy', 'string', [
                'default' => 'public',
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('author_location', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('file_path', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('file_mime_type', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('video_type', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('author_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('audio_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('album_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('genre_refid', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('categories', 'text', [
                'default' => null,
                'limit' => 16777215,
                'null' => true,
            ])
            ->addColumn('release_date', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => 'published',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_debut', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('monetize', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('total_plays', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('number_of_people_played', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('number_of_downloads', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'audio_refid',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'id',
                ]
            )
            ->addIndex(
                [
                    'author_refid',
                ]
            )
            ->addIndex(
                [
                    'album_refid',
                ]
            )
            ->addIndex(
                [
                    'genre_refid',
                ]
            )
            ->create();

        $this->table('activities')
            ->addForeignKey(
                'activity_type_id',
                'activity_types',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->addForeignKey(
                'actor_refid',
                'users',
                'refid',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'activity_subject_id',
                'activity_subjects',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->update();

        $this->table('categories')
            ->addForeignKey(
                'type_id',
                'category_types',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'RESTRICT',
                ]
            )
            ->addForeignKey(
                'parent_refid',
                'categories',
                'refid',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'RESTRICT',
                ]
            )
            ->update();

        $this->table('connections')
            ->addForeignKey(
                'correspondent_refid',
                'users',
                'refid',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->addForeignKey(
                'user_refid',
                'users',
                'refid',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->update();

        $this->table('follows')
            ->addForeignKey(
                'followee_refid',
                'users',
                'refid',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->addForeignKey(
                'follower_refid',
                'users',
                'refid',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->update();

        $this->table('genres')
            ->addForeignKey(
                'industry_id',
                'industries',
                'id',
                [
                    'update' => 'SET_NULL',
                    'delete' => 'SET_NULL',
                ]
            )
            ->addForeignKey(
                'parent_refid',
                'genres',
                'refid',
                [
                    'update' => 'SET_NULL',
                    'delete' => 'SET_NULL',
                ]
            )
            ->update();

        $this->table('group_invites')
            ->addForeignKey(
                'sender_refid',
                'users',
                'refid',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'group_id',
                'groups',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'invitee_refid',
                'users',
                'refid',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->update();

        $this->table('group_join_requests')
            ->addForeignKey(
                'group_id',
                'groups',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'user_refid',
                'users',
                'refid',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->update();

        $this->table('group_medias')
            ->addForeignKey(
                'user_refid',
                'users',
                'refid',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->addForeignKey(
                'group_id',
                'groups',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->update();

        $this->table('group_members')
            ->addForeignKey(
                'user_refid',
                'users',
                'refid',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->addForeignKey(
                'group_id',
                'groups',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->addForeignKey(
                'approved_by',
                'users',
                'refid',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'invited_by',
                'users',
                'refid',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->update();

        $this->table('group_posts')
            ->addForeignKey(
                'user_refid',
                'users',
                'refid',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->addForeignKey(
                'group_id',
                'groups',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'post_refid',
                'posts',
                'refid',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->update();

        $this->table('groups')
            ->addForeignKey(
                'author',
                'users',
                'refid',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->update();

        $this->table('hall_of_famers')
            ->addForeignKey(
                'user_refid',
                'users',
                'refid',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->update();

        $this->table('industries')
            ->addForeignKey(
                'parent_id',
                'industries',
                'id',
                [
                    'update' => 'SET_NULL',
                    'delete' => 'SET_NULL',
                ]
            )
            ->update();

        $this->table('profiles')
            ->addForeignKey(
                'user_refid',
                'users',
                'refid',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'RESTRICT',
                ]
            )
            ->update();

        $this->table('requests')
            ->addForeignKey(
                'recipient_refid',
                'users',
                'refid',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'sender_refid',
                'users',
                'refid',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->update();

        $this->table('roles')
            ->addForeignKey(
                'industry_id',
                'industries',
                'id',
                [
                    'update' => 'SET_NULL',
                    'delete' => 'SET_NULL',
                ]
            )
            ->addForeignKey(
                'parent_id',
                'roles',
                'id',
                [
                    'update' => 'SET_NULL',
                    'delete' => 'SET_NULL',
                ]
            )
            ->update();

        $this->table('talent_hub')
            ->addForeignKey(
                'industry_id',
                'industries',
                'id',
                [
                    'update' => 'SET_NULL',
                    'delete' => 'SET_NULL',
                ]
            )
            ->addForeignKey(
                'series_id',
                'series',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'talent_id',
                'talent_hub',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'user_refid',
                'users',
                'refid',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->update();

        $this->table('user_genres')
            ->addForeignKey(
                'genre_id',
                'genres',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'RESTRICT',
                ]
            )
            ->addForeignKey(
                'profile_id',
                'profiles',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'RESTRICT',
                ]
            )
            ->update();

        $this->table('user_industries')
            ->addForeignKey(
                'industry_id',
                'industries',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'RESTRICT',
                ]
            )
            ->addForeignKey(
                'profile_id',
                'profiles',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'RESTRICT',
                ]
            )
            ->update();

        $this->table('user_preferences')
            ->addForeignKey(
                'user_id',
                'users',
                'refid',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->update();

        $this->table('user_roles')
            ->addForeignKey(
                'profile_id',
                'profiles',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->addForeignKey(
                'role_id',
                'roles',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->update();

        $this->table('users_ratings')
            ->addForeignKey(
                'actor_refid',
                'users',
                'refid',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION',
                ]
            )
            ->addForeignKey(
                'user_refid',
                'users',
                'refid',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE',
                ]
            )
            ->update();
    }

    /**
     * Down Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-down-method
     * @return void
     */
    public function down()
    {
        $this->table('activities')
            ->dropForeignKey(
                'activity_type_id'
            )
            ->dropForeignKey(
                'actor_refid'
            )
            ->dropForeignKey(
                'activity_subject_id'
            )->save();

        $this->table('categories')
            ->dropForeignKey(
                'type_id'
            )
            ->dropForeignKey(
                'parent_refid'
            )->save();

        $this->table('connections')
            ->dropForeignKey(
                'correspondent_refid'
            )
            ->dropForeignKey(
                'user_refid'
            )->save();

        $this->table('follows')
            ->dropForeignKey(
                'followee_refid'
            )
            ->dropForeignKey(
                'follower_refid'
            )->save();

        $this->table('genres')
            ->dropForeignKey(
                'industry_id'
            )
            ->dropForeignKey(
                'parent_refid'
            )->save();

        $this->table('group_invites')
            ->dropForeignKey(
                'sender_refid'
            )
            ->dropForeignKey(
                'group_id'
            )
            ->dropForeignKey(
                'invitee_refid'
            )->save();

        $this->table('group_join_requests')
            ->dropForeignKey(
                'group_id'
            )
            ->dropForeignKey(
                'user_refid'
            )->save();

        $this->table('group_medias')
            ->dropForeignKey(
                'user_refid'
            )
            ->dropForeignKey(
                'group_id'
            )->save();

        $this->table('group_members')
            ->dropForeignKey(
                'user_refid'
            )
            ->dropForeignKey(
                'group_id'
            )
            ->dropForeignKey(
                'approved_by'
            )
            ->dropForeignKey(
                'invited_by'
            )->save();

        $this->table('group_posts')
            ->dropForeignKey(
                'user_refid'
            )
            ->dropForeignKey(
                'group_id'
            )
            ->dropForeignKey(
                'post_refid'
            )->save();

        $this->table('groups')
            ->dropForeignKey(
                'author'
            )->save();

        $this->table('hall_of_famers')
            ->dropForeignKey(
                'user_refid'
            )->save();

        $this->table('industries')
            ->dropForeignKey(
                'parent_id'
            )->save();

        $this->table('profiles')
            ->dropForeignKey(
                'user_refid'
            )->save();

        $this->table('requests')
            ->dropForeignKey(
                'recipient_refid'
            )
            ->dropForeignKey(
                'sender_refid'
            )->save();

        $this->table('roles')
            ->dropForeignKey(
                'industry_id'
            )
            ->dropForeignKey(
                'parent_id'
            )->save();

        $this->table('talent_hub')
            ->dropForeignKey(
                'industry_id'
            )
            ->dropForeignKey(
                'series_id'
            )
            ->dropForeignKey(
                'talent_id'
            )
            ->dropForeignKey(
                'user_refid'
            )->save();

        $this->table('user_genres')
            ->dropForeignKey(
                'genre_id'
            )
            ->dropForeignKey(
                'profile_id'
            )->save();

        $this->table('user_industries')
            ->dropForeignKey(
                'industry_id'
            )
            ->dropForeignKey(
                'profile_id'
            )->save();

        $this->table('user_preferences')
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('user_roles')
            ->dropForeignKey(
                'profile_id'
            )
            ->dropForeignKey(
                'role_id'
            )->save();

        $this->table('users_ratings')
            ->dropForeignKey(
                'actor_refid'
            )
            ->dropForeignKey(
                'user_refid'
            )->save();

        $this->table('achievements')->drop()->save();
        $this->table('activities')->drop()->save();
        $this->table('activity_subjects')->drop()->save();
        $this->table('activity_types')->drop()->save();
        $this->table('albums')->drop()->save();
        $this->table('audios')->drop()->save();
        $this->table('awards')->drop()->save();
        $this->table('categories')->drop()->save();
        $this->table('category_items')->drop()->save();
        $this->table('category_types')->drop()->save();
        $this->table('causes')->drop()->save();
        $this->table('chat_correspondents')->drop()->save();
        $this->table('chat_participants')->drop()->save();
        $this->table('chats')->drop()->save();
        $this->table('comedians_profiles')->drop()->save();
        $this->table('comments')->drop()->save();
        $this->table('connections')->drop()->save();
        $this->table('conversations')->drop()->save();
        $this->table('e_news')->drop()->save();
        $this->table('emails')->drop()->save();
        $this->table('event_guests')->drop()->save();
        $this->table('event_invitees')->drop()->save();
        $this->table('event_types')->drop()->save();
        $this->table('event_venues')->drop()->save();
        $this->table('events')->drop()->save();
        $this->table('follows')->drop()->save();
        $this->table('foundations')->drop()->save();
        $this->table('genres')->drop()->save();
        $this->table('group_invites')->drop()->save();
        $this->table('group_join_requests')->drop()->save();
        $this->table('group_medias')->drop()->save();
        $this->table('group_members')->drop()->save();
        $this->table('group_posts')->drop()->save();
        $this->table('groups')->drop()->save();
        $this->table('guests')->drop()->save();
        $this->table('hall_of_famers')->drop()->save();
        $this->table('industries')->drop()->save();
        $this->table('media_views')->drop()->save();
        $this->table('medias')->drop()->save();
        $this->table('messages')->drop()->save();
        $this->table('movie_makers_profiles')->drop()->save();
        $this->table('movie_stars')->drop()->save();
        $this->table('music_categories')->drop()->save();
        $this->table('music_profiles')->drop()->save();
        $this->table('musical_instruments')->drop()->save();
        $this->table('newsfeeds')->drop()->save();
        $this->table('nominations')->drop()->save();
        $this->table('notifications')->drop()->save();
        $this->table('phones')->drop()->save();
        $this->table('photos')->drop()->save();
        $this->table('playlist_items')->drop()->save();
        $this->table('playlists')->drop()->save();
        $this->table('post_attachments')->drop()->save();
        $this->table('post_reactions')->drop()->save();
        $this->table('posts')->drop()->save();
        $this->table('profiles')->drop()->save();
        $this->table('promoted_contents')->drop()->save();
        $this->table('requests')->drop()->save();
        $this->table('roles')->drop()->save();
        $this->table('series')->drop()->save();
        $this->table('shows_profiles')->drop()->save();
        $this->table('subscriptions')->drop()->save();
        $this->table('tags')->drop()->save();
        $this->table('talent_hub')->drop()->save();
        $this->table('talents')->drop()->save();
        $this->table('unique_attributes')->drop()->save();
        $this->table('user_entities')->drop()->save();
        $this->table('user_genres')->drop()->save();
        $this->table('user_industries')->drop()->save();
        $this->table('user_interests')->drop()->save();
        $this->table('user_preferences')->drop()->save();
        $this->table('user_properties')->drop()->save();
        $this->table('user_roles')->drop()->save();
        $this->table('users')->drop()->save();
        $this->table('users_ratings')->drop()->save();
        $this->table('videos')->drop()->save();
    }
}
