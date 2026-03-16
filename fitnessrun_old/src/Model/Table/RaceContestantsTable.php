<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RaceContestants Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Races
 * @property \Cake\ORM\Association\BelongsTo $Contestants
 *
 * @method \App\Model\Entity\RaceContestant get($primaryKey, $options = [])
 * @method \App\Model\Entity\RaceContestant newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RaceContestant[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RaceContestant|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RaceContestant patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RaceContestant[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RaceContestant findOrCreate($search, callable $callback = null)
 */
class RaceContestantsTable extends Table
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

        $this->table('race_contestants');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Races', [
            'foreignKey' => 'race_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Contestants', [
            'foreignKey' => 'contestant_id',
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
        $rules->add($rules->existsIn(['race_id'], 'Races'));
        $rules->add($rules->existsIn(['contestant_id'], 'Contestants'));

        return $rules;
    }
}
