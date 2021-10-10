<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PromotedContent Entity
 *
 * @property int $id
 * @property string $content_refid
 * @property string $promoter_refid
 * @property string $content_type
 * @property string $content_repository
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property \Cake\I18n\FrozenTime|null $published
 * @property string|null $status
 * @property string|null $audience_age_bracket
 * @property string|null $audience_gender
 * @property string|null $audience_locations
 * @property \Cake\I18n\FrozenTime|null $start_date
 * @property string|null $end_date
 * @property string|null $budget_currency
 * @property float $budget_amount
 */
class PromotedContent extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'content_refid' => true,
        'promoter_refid' => true,
        'content_type' => true,
        'content_repository' => true,
        'created' => true,
        'modified' => true,
        'published' => true,
        'status' => true,
        'audience_age_bracket' => true,
        'audience_gender' => true,
        'audience_locations' => true,
        'start_date' => true,
        'end_date' => true,
        'budget_currency' => true,
        'budget_amount' => true,
    ];
}
