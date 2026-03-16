<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContestantFinishtime Entity
 *
 * @property int $id
 * @property string $contestant_id
 * @property int $race_id
 * @property \Cake\I18n\Time $finishtime
 *
 * @property \App\Model\Entity\Contestant $contestant
 * @property \App\Model\Entity\Race $race
 */
class ContestantFinishtime extends Entity
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
        '*' => true,
        'id' => false
    ];
}
