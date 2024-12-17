<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SleepRecord $sleepRecord
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $sleepRecord->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $sleepRecord->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Sleep Records'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="sleepRecords form content">
            <?= $this->Form->create($sleepRecord) ?>
            <fieldset>
                <legend><?= __('Edit Sleep Record') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('date');
                    echo $this->Form->control('bedtime');
                    echo $this->Form->control('wakeup_time');
                    echo $this->Form->control('nap_afternoon');
                    echo $this->Form->control('nap_evening');
                    echo $this->Form->control('mood');
                    echo $this->Form->control('comment');
                    echo $this->Form->control('sport');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
