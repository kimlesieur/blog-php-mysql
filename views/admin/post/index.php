<?php 
use App\Connection;
use App\Table\PostTable;
use App\Auth;

Auth::check();

$title = "Administration";
$pdo = Connection::getPDO();
[$posts, $pagination] = (new PostTable($pdo))->findPaginated();

$link = $router->url('admin_posts');
?>

<?php if (isset($_GET['delete'])): ?>
    <div class="alert alert-success">
        L'enregistrement id #<?=$_GET['postID']?> a bien été supprimé
    </div>
    <?php endif ?>
    
    <a href="<?= $router->url('admin_post_new') ?>" class="btn btn-primary m-2">Nouvel article</a>
    <table class="table">
        
        <thead>
            <th>#</th>
            <th>Titre</th>
            <th>Actions</th>
        </thead>
        <tbody>
            <?php foreach($posts as $post): ?>
            <tr>
                <td>#<?= $post->getId() ?></td>
                <td>
                    <a href="<?= $router->url('admin_post', ['id' => $post->getId()]) ?>">
                    <?= e($post->getName()) ?>
                    </a>
                </td>
                <td>
                    <a href="<?= $router->url('admin_post', ['id' => $post->getId()]) ?>" class="btn btn-primary">
                        Editer
                    </a>
                    <form action="<?= $router->url('admin_post_delete', ['id' => $post->getId()]) ?>" method="POST"
                        onsubmit="return confirm('Voulez vous vraiment effectuer cette action ?')" style="display:inline">
                        <button type="submit"  class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    
<div class="d-flex justify-content-between my-4">
    <?= $pagination->previousLink($link); ?>
    <?= $pagination->nextLink($link); ?>
</div>

