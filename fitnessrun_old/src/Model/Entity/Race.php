<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Race Entity
 *
 * @property int $id
 * @property string $name
 * @property \Cake\I18n\Time $starttime
 * @property bool $active
 * @property \Cake\I18n\Time $endtime
 *
 * @property \App\Model\Entity\ContestantFinishtime[] $contestant_finishtimes
 * @property \App\Model\Entity\ContestantLap[] $contestant_laps
 * @property \App\Model\Entity\RaceContestant[] $race_contestants
 * @property \App\Model\Entity\RaceFinishtime[] $race_finishtimes
 */
class Race extends Entity
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
