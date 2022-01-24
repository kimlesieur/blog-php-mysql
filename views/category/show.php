<?php 
use App\Connection;
use App\Model\{Categorie, Post};
use App\PaginatedQuery;
use App\Table\CategorieTable;
use App\Table\PostTable;
use App\Url;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();

$categoryTable = new CategorieTable($pdo);
$categorie = $categoryTable->find($id);

if($categorie === false){
    throw new Exception("Aucune catégorie ne correspond à l'id : {$id}");
}

//Redirection si le slug présent dans l'URL ne correspond pas au vrai slug de l'article affiché
if($categorie->getSlug() !== $slug){
    $url = $router->url('category', ['id' => $id, 'slug' => $category->getSlug()]);
    header('Location:' . $url);
}

$title =  "Catégorie {$categorie->getName()}";

$postsTable = new PostTable($pdo);
[$posts, $pagination] = $postsTable->findPaginatedForCategory($categorie->getId());

//pour créer l'url de base de la catégorie et y ajouter des paramètres ?page=X dans la pagination
$link = $router->url('category', ['id'=>$categorie->getId(), 'slug'=>$categorie->getSlug()]);
?>

<h1><?= e($title) ?></h1>

<div class="row"></div>
    <?php foreach($posts as $post): ?>
    <div class="col-md-3">
        <?php require dirname(__DIR__) .'/post/card.php' ?>
    </div>
    <?php endforeach ?>
</div>

<div class="d-flex justify-content-between my-4">
    <?= $pagination->previousLink($link) ?>
    <?= $pagination->nextLink($link) ?>
</div>




