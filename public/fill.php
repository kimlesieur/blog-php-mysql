<?php 
require dirname(__DIR__) . '/vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

$pdo = new PDO ("mysql:dbname={$_SERVER["DB_NAME"]};host={$_SERVER["HOST_NAME"]}", "{$_SERVER["USERNAME"]}", "{$_SERVER["PASSWORD"]}", 
[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

/*
Original code for localhost : 
new PDO ('mysql:dbname=blog;host=127.0.0.1', 'root', 'root', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

For heroku :
$pdo = new PDO ('mysql:dbname=heroku_b125d2bc6173655;host=eu-cdbr-west-02.cleardb.net', 'bee6bc79cedcc9', 'fbc907f0', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
*/



$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE post_category');
$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE category');
$pdo->exec('TRUNCATE TABLE user');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

$postsID = [];
$categoriesID = [];

for ($i=0; $i<50 ; $i++){
    $pdo->exec("INSERT INTO post SET name='{$faker->sentence()}', slug='{$faker->slug()}', created_at='{$faker->date()} {$faker->time()}', content='{$faker->paragraph(rand(3, 8))}' ");
    $postsID[] = $pdo->lastInsertId();
}

for ($i=0; $i<5 ; $i++){
    $pdo->exec("INSERT INTO category SET name='{$faker->words(2, true)}', slug='{$faker->slug()}' ");
    $categoriesID[] = $pdo->lastInsertId();
}

/*Une 1ère boucle foreach passe sur chaque élément $post de l'array $posts. 
*On définit un array $randomCategories composé de multiples arrays de $catégoriesID choisies au hasard.
*Une 2ème boucle passe sur chaque array de $randomCategories et à chaque ligne associe un ID de post à un array d'ID de catégories.
*/
foreach($postsID as $post){
    $randomCategories = $faker->randomElements($categoriesID, rand(0, count($categoriesID)));
    foreach($randomCategories as $categories){
        $pdo->exec("INSERT INTO post_category SET post_id=$post, category_id=$categories");
    }
}

$password = password_hash('admin', PASSWORD_DEFAULT);
$pdo->exec("INSERT INTO user SET username='admin', password=$password");





