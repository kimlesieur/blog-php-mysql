<?php 
use App\Connection;
use App\Table\PostTable;

$title = "Mon Blog";

$pdo = Connection::getPDO();

$postsTable = new PostTable($pdo);
[$posts, $pagination] = $postsTable->findPaginated();

$link = $router->url('accueil');


?>

<h1>Mes articles</h1>

<div class="row"></div>
    <?php foreach($posts as $post): ?>
    <div class="col-md-3">
        <?php require 'card.php' ?>
    </div>
    <?php endforeach ?>
</div>
<div class="d-flex justify-content-between my-4">
    <?= $pagination->previousLink($link) ?>
    <?= $pagination->nextLink($link) ?>
</div>



