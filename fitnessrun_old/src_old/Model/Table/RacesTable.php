<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Races Model
 *
 * @property \Cake\ORM\Association\HasMany $ContestantFinishtimes
 * @property \Cake\ORM\Association\HasMany $ContestantLaps
 * @property \Cake\ORM\Association\HasMany $RaceContestants
 *
 * @method \App\Model\Entity\Race get($primaryKey, $options = [])
 * @method \App\Model\Entity\Race newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Race[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Race|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Race patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Race[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Race findOrCreate($search, callable $callback = null)
 */
class RacesTable extends Table
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

        $this->table('races');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('ContestantFinishtimes', [
            'foreignKey' => 'race_id'
        ]);

        $this->hasMany('ContestantLaps', [
            'foreignKey' => 'race_id'
        ]);
        $this->hasMany('RaceContestants', [
            'foreignKey' => 'race_id'
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

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->dateTime('starttime')
            ->requirePresence('starttime', 'create')
            ->notEmpty('starttime');

        $validator
            ->boolean('active')
            ->requirePresence('active', 'create')
            ->notEmpty('active');

        $validator
            ->dateTime('endtime')
            ->requirePresence('endtime', 'create')
            ->notEmpty('endtime');

        return $validator;
    }
}
