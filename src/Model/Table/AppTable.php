<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Behavior\CommonBehavior;
use Cake\Database\Expression\QueryExpression;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Validation\Validator;

/**
 * Custom Parent Model
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin CommonBehavior
 */
class AppTable extends Table {

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->addBehavior('Timestamp', ['timezone' => 'GMT']);
        $this->addBehavior('Common');
    }


    /**
     * Retrieve recently released song, video, comic video, etc
     * This includes only items released only 30 days ago, counting backwards
     * from the present day.
     *
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findNewReleases(Query $query, array $options = null)
    {
        $query = $query->where(function (QueryExpression $exp, Query $q) {
            // Created between now and 4 days back, that has been read
            $table = Inflector::camelize($this->getTable());
            return $exp->between(
                "$table.created",
                new \DateTime('now'),
                new \DateTime('-4 days')
            );
        });

        return $query;
    }

    /**
     * Find items released on a specific date
     *
     * @param Query $query
     * @param array $options
     */
    public function findByReleaseDate(Query $query, array $options)
    {
        $table = Inflector::camelize($this->getTable());
        return $query->where([
            "$table.release_date" => new \DateTime($options['date'])
        ]);
    }


    public function findTrending(Query $query, array $options)
    {

        $query->matching('MediaViews', function (Query $q) use ($options) {
            $table = Inflector::camelize($this->getTable());
            $q->select(['count' => $q->func()->count('*')])
                ->enableAutoFields(true)
                ->where([
                    'media_refid' => "$table.refid",
                    'view_date >=' => new \DateTime($options['period'])
                ])
                ->having(['count >=' => 100]);

            return $q;
        });

        return $query;
    }

    public function findBestSellers(Query $query, array $options = null)
    {
        // To be implemented

        return $query;
    }


    public function findByAuthor(Query $query, array $options)
    {
        return $query->where(['author_refid' => $options['author']]);
    }

}
