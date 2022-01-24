<?php 
$postId !== null ? $bouton = 'Modifier' : $bouton = 'Créer';
?>


<form action="" method="POST">
    <?= $form->input('name', 'Titre'); ?>
    <?= $form->input('slug', 'URL'); ?>
    <?= $form->textarea('content', 'Contenu'); ?>
    <?= $form->input('created_at', 'Date de création'); ?>
    
    <button class="btn btn-primary"><?= $bouton ?></button>
</form>