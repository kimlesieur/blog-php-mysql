<?php
use App\Connection;
use App\Table\PostTable;
use App\HTML\Form;
use App\Validators\PostValidator;
use App\Helpers\tools;

$pdo = Connection::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($params['id']);
$success = false; 

$errors = [];

if (!empty($_POST)){
    //Définition d'une classe avec méthode statique pour remplir les champs des formulaires 
    tools::fillFields($post, $_POST, ['name', 'slug', 'content', 'created_at']);

    $v = new PostValidator($_POST, $postTable, $post->getId());
    if ($v->validate()){
        $postTable->update($post);
        $success = true;
    } else {
        $errors = $v->errors();
    }
} 

$postId = $post->getId();

//Instanciation du formulaire avec l'objet Post et le tableau d'erreurs courant
$form = new Form($post, $errors);

?>
<!--Pour afficher simplement un message de validation de màj, 
on définit une variable $success en false puis on la passe en true 
si la superglobale $_POST n'est pas vide (siginifiant que l'on tente d'envoyer des données via POST)-->

<?php if($success): ?>
<div class="alert alert-success">
    L'article <?=$postId?> a été modifié avec succès.
</div>
<?php endif; ?>

<?php if(isset($_GET['created'])): ?>
<div class="alert alert-success">
    L'article a bien été créé.
</div>
<?php endif; ?>

<?php if(!empty($errors)): ?>
<div class="alert alert-danger">
    L'article <?=$postId?> n'a pas pu être modifié.
</div>
<?php endif; ?>

<h1>Editer l'article : <?= "id #".e($postId) . " - " . e($post->getName()) ?></h1>


<?php require('_form.php') ?>