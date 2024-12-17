<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Menus Model
 *
 * @method \App\Model\Entity\Menu newEmptyEntity()
 * @method \App\Model\Entity\Menu newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Menu> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Menu get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Menu findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Menu patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Menu> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Menu|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Menu saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Menu>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Menu>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Menu>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Menu> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Menu>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Menu>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Menu>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Menu> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MenusTable extends Table
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

        $this->setTable('menus');
        $this->setDisplayField('intitule');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->integer('ordre')
            ->requirePresence('ordre', 'create')
            ->notEmptyString('ordre');

        $validator
            ->scalar('intitule')
            ->maxLength('intitule', 255)
            ->requirePresence('intitule', 'create')
            ->notEmptyString('intitule');

        $validator
            ->scalar('lien')
            ->maxLength('lien', 255)
            ->requirePresence('lien', 'create')
            ->notEmptyString('lien');

        return $validator;
    }
}
