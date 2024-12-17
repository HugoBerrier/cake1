<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SleepRecords Controller
 *
 * @property \App\Model\Table\SleepRecordsTable $SleepRecords
 */
class SleepRecordsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $selectedUserId = $this->request->getQuery('user_id');

        $conditions = [];
        if ($selectedUserId) {
            $conditions['user_id'] = $selectedUserId;
        }

        $query = $this->SleepRecords->find()
            ->contain(['Users'])
            ->where($conditions);
        $sleepRecords = $this->paginate($query);

        $users = $this->SleepRecords->Users->find('list')->toArray();

        $this->set(compact('sleepRecords', 'users', 'selectedUserId'));
    }

    /**
     * View method
     *
     * @param string|null $id Sleep Record id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sleepRecord = $this->SleepRecords->get($id, contain: ['Users']);
        $this->set(compact('sleepRecord'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sleepRecord = $this->SleepRecords->newEmptyEntity();
        if ($this->request->is('post')) {
            $sleepRecord = $this->SleepRecords->patchEntity($sleepRecord, $this->request->getData());
            if ($this->SleepRecords->save($sleepRecord)) {
                $this->Flash->success(__('The sleep record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sleep record could not be saved. Please, try again.'));
        }
        $users = $this->SleepRecords->Users->find('list', limit: 200)->all();
        $this->set(compact('sleepRecord', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sleep Record id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sleepRecord = $this->SleepRecords->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sleepRecord = $this->SleepRecords->patchEntity($sleepRecord, $this->request->getData());
            if ($this->SleepRecords->save($sleepRecord)) {
                $this->Flash->success(__('The sleep record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sleep record could not be saved. Please, try again.'));
        }
        $users = $this->SleepRecords->Users->find('list', limit: 200)->all();
        $this->set(compact('sleepRecord', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sleep Record id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sleepRecord = $this->SleepRecords->get($id);
        if ($this->SleepRecords->delete($sleepRecord)) {
            $this->Flash->success(__('The sleep record has been deleted.'));
        } else {
            $this->Flash->error(__('The sleep record could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function weeklySummary($weekOffset = 0, $period = 'week')
    {
        $selectedUserId = $this->request->getQuery('user_id');

        if ($period === 'month') {
            $startDate = new \DateTime('first day of this month');
            $startDate->modify("$weekOffset month");
            $endDate = clone $startDate;
            $endDate->modify('last day of this month');
        } else {
            $startDate = new \DateTime('last Monday');
            $startDate->modify("$weekOffset week");
            $endDate = clone $startDate;
            $endDate->modify('next Sunday');
        }

        $conditions = [
            'date >=' => $startDate->format('Y-m-d'),
            'date <=' => $endDate->format('Y-m-d')
        ];

        if ($selectedUserId) {
            $conditions['user_id'] = $selectedUserId;
        }

        $sleepRecords = $this->SleepRecords->find('all', conditions: $conditions)->toArray();

        $totalSleepCycles = array_sum(array_map(function($record) {
            return $record->sleep_cycles;
        }, $sleepRecords));

        $averageSleepCycles = count($sleepRecords) > 0 ? $totalSleepCycles / count($sleepRecords) : 0;

        $consecutiveDays = 0;
        $currentStreak = 0;
        foreach ($sleepRecords as $record) {
            if ($record->sleep_cycles >= 5) {
                $currentStreak++;
                if ($currentStreak > $consecutiveDays) {
                    $consecutiveDays = $currentStreak;
                }
            } else {
                $currentStreak = 0;
            }
        }

        $totalCyclesIndicator = $totalSleepCycles >= 42 ? 'green' : 'red';
        $consecutiveDaysIndicator = $consecutiveDays >= 4 ? 'green' : 'red';

        $users = $this->SleepRecords->Users->find('list')->toArray();

        $this->set(compact('sleepRecords', 'totalSleepCycles', 'averageSleepCycles', 'consecutiveDays', 'totalCyclesIndicator', 'consecutiveDaysIndicator', 'weekOffset', 'period', 'users', 'selectedUserId'));
    }
}
