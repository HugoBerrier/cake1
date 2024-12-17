<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SleepRecords Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\SleepRecord newEmptyEntity()
 * @method \App\Model\Entity\SleepRecord newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\SleepRecord> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SleepRecord get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\SleepRecord findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\SleepRecord patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\SleepRecord> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SleepRecord|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\SleepRecord saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\SleepRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SleepRecord>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SleepRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SleepRecord> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SleepRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SleepRecord>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SleepRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SleepRecord> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SleepRecordsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('sleep_records');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
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
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->time('bedtime')
            ->requirePresence('bedtime', 'create')
            ->notEmptyTime('bedtime');

        $validator
            ->time('wakeup_time')
            ->requirePresence('wakeup_time', 'create')
            ->notEmptyTime('wakeup_time');

        $validator
            ->boolean('nap_afternoon')
            ->requirePresence('nap_afternoon', 'create')
            ->notEmptyString('nap_afternoon');

        $validator
            ->boolean('nap_evening')
            ->requirePresence('nap_evening', 'create')
            ->notEmptyString('nap_evening');

        $validator
            ->integer('mood')
            ->requirePresence('mood', 'create')
            ->notEmptyString('mood');

        $validator
            ->scalar('comment')
            ->requirePresence('comment', 'create')
            ->notEmptyString('comment');

        $validator
            ->boolean('sport')
            ->requirePresence('sport', 'create')
            ->notEmptyString('sport');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
