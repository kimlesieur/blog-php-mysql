<?php 
//besoin de use($router) car la variable $router provient de l'extérieur de la fonction (hors scope)
$functionA = function($categorie) use ($router) {
    $categorie_url = $router->url('category', ['id' => $categorie->getId(), 'slug' => $categorie->getSlug()] );
    return <<<HTML
    <a href="{$categorie_url}">{$categorie->getName()}</a>
HTML;
};
$categories = array_map($functionA, $post->getCategories());

?>

<div class="card bg-light mb-3" style="max-width: 18rem;">
    <div class="card-header">
        <h5 class="card-title"><?= e($post->getName()) ?></h5>
        <p class="text-muted"><?= $post->getCreatedAt()->format('d F Y') ?></p>
            <?php if(!empty($post->getCategories())): ?>
            <?= implode(', ', $categories) ?>
            <?php endif; ?>
    </div>
    <div class="card-body">
        <p><?= $post->getExcerpt() ?></p>
        <p>
            <a href="<?= $router->url('article', ['id'=>$post->getID(), 'slug'=>$post->getSlug()]) ?>" class="btn btn-primary bg-info">Voir plus</a>
        </p>
    </div>
</div>