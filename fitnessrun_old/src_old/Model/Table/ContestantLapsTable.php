<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContestantLaps Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Contestants
 * @property \Cake\ORM\Association\BelongsTo $Races
 *
 * @method \App\Model\Entity\ContestantLap get($primaryKey, $options = [])
 * @method \App\Model\Entity\ContestantLap newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ContestantLap[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ContestantLap|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ContestantLap patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ContestantLap[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ContestantLap findOrCreate($search, callable $callback = null)
 */
class ContestantLapsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('contestant_laps');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Contestants', [
            'foreignKey' => 'contestant_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Races', [
            'foreignKey' => 'race_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['contestant_id'], 'Contestants'));
        $rules->add($rules->existsIn(['race_id'], 'Races'));

        return $rules;
    }
}
