<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $menu
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Menus'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="menus form content">
            <?= $this->Form->create($menu) ?>
            <fieldset>
                <legend><?= __('Add Menu') ?></legend>
                <?php
                    echo $this->Form->control('ordre');
                    echo $this->Form->control('intitule');
                    echo $this->Form->control('lien');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit'), ['class' => '', 'style' => 'background-color: blue; border-color: blue;']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
