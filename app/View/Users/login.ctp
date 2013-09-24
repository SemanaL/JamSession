<div class="users form">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Ce site n\'est pas un site sur le cyclimse. Merci de votre compréhension'); ?></legend>
        <?php echo $this->Form->input('username',array('label'=>'Utilisateur'));
        echo $this->Form->input('password',array('label'=>'Mot de Passe'));
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Login')); ?>
</div>