<?php 
use App\Connection;
use App\Model\Categorie;
use App\Model\Post;
use App\Table\CategorieTable;
use App\Table\PostTable;

$id = $params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();

$post = (new PostTable($pdo))->find($id);
(new CategorieTable($pdo))->hydratePosts([$post]);

if($post === false){
    throw new Exception("Aucun article ne correspond à l'id : {$id}");
}

//Redirection si le slug présent dans l'URL ne correspond pas au vrai slug de l'article affiché
if($post->getSlug() !== $slug){
    $url = $router->url('article', ['id' => $id, 'slug' => $post->getSlug()]);
    header('Location:' . $url);
}

?>

<h1><?= e($post->getName()) ?></h1>
<p class="text-muted"><?= $post->getCreatedAt()->format('d F Y') ?></p>
<?php foreach($post->getCategories() as $index => $categorie): ?>
    <?php if($index>0){ echo ",";} ?>
    <?php $categorie_url = $router->url('category', ['id' => $categorie->getId(), 'slug' => $categorie->getSlug()] ); ?>
    <a href="<?=$categorie_url?>"><?= e($categorie->getName()) ?></a>
<?php endforeach; ?>
<p><?= $post->getFormattedContent() ?></p>



