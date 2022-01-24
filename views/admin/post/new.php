<?php
use App\Connection;
use App\Table\PostTable;
use App\HTML\Form;
use App\Validators\PostValidator;
use App\helpers\tools;
use App\Model\Post;

$errors = [];
$post = new Post();
$post->setCreatedAt(date('Y-m-d H:i:s'));
 
if (!empty($_POST)){
       
    $pdo = Connection::getPDO();
    $postTable = new PostTable($pdo);

    //Définition d'une classe avec méthode statique pour remplir les champs des formulaires 
    tools::fillFields($post, $_POST, ['name', 'slug', 'content', 'created_at']);

    $v = new PostValidator($_POST, $postTable, $post->getId());
    if ($v->validate()){
        $postTable->create($post);
        header('Location:'.$router->url('admin_post', ['id' => $post->getId()]) . '?created=1');
        exit();
      
    } else {
        $errors = $v->errors();
    }
} 


//Instanciation du formulaire avec l'objet Post et le tableau d'erreurs courant
$form = new Form($post, $errors);
$postId = $post->getId();
?>

<!--Pour afficher simplement un message de validation de màj, 
on définit une variable $success en false puis on la passe en true 
si la superglobale $_POST n'est pas vide (siginifiant que l'on tente d'envoyer des données via POST)-->


<h1>Créer un nouvel article</h1>


<?php require('_form.php') ?>