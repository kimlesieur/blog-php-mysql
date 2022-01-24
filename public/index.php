<?php 
require dirname(__DIR__) . '/vendor/autoload.php';

define('DEBUG_TIME', microtime(true));
/* 
Librairie Whoops pour visualisation des erreurs plus détaillée
*/
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

if(isset($_GET['page']) && $_GET['page'] === '1'){
    $paramsUrl = explode('?', $_SERVER['REQUEST_URI']);
    $uri = $paramsUrl[0];
    //On travaille sur une copie de $_GET pour éviter les erreurs de compilation potentielles
    $get = $_GET;
    unset($get['page']);
    //permet de reconstruire une URI en spécifiant un array de paramètres sous forme "?clé1=valeur1&clé2=valeur2"
    $query = http_build_query($get);
    //vérifie si n'est pas vide
    if(!empty($query)){
        $uri = $uri. '?' . $query;
    }
    http_response_code(301);
    header('Location:' . $uri);
    exit();
}


$router = new App\Router(dirname(__DIR__).'/views');
$router 
    ->get('/', '/post/index', 'accueil')
    ->get('/blog/category/[*:slug]-[i:id]', '/category/show', 'category')
    ->get('/blog/[*:slug]-[i:id]', '/post/show', 'article')
    ->get('/admin', '/admin/post/index', 'admin_posts')
    ->match('/admin/post/[i:id]', '/admin/post/edit', 'admin_post')
    ->post('/admin/post/[i:id]/delete', '/admin/post/delete', 'admin_post_delete')
    ->match('/admin/post/new', '/admin/post/new', 'admin_post_new')
    ->run();

