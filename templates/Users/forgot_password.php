    <div class="users form">
        <?= $this->Flash->render() ?>
        <h3>Réinitialisation du mot de passe</h3>
        <?= $this->Form->create() ?>
        <fieldset>
            <legend><?= __('Veuillez entrer votre adresse email') ?></legend>
            <?= $this->Form->control('email', ['required' => true]) ?>
        </fieldset>
        <?= $this->Form->submit(__('Envoyer')); ?>
        <?= $this->Form->end() ?>

        <?php if (isset($newPassword)): ?>
            <div class="new-password">
                <h4><?= __('Votre nouveau mot de passe est :') ?></h4>
                <p><?= h($newPassword) ?></p>
            </div>
        <?php endif; ?>
    </div>
