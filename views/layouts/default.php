<!DOCTYPE html>
<html lang="fr" class="h-100">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?= isset($tite) ? e($title) : "Mon site" ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    </head>
<body class="d-flex flex-column h-100">

    <nav class="navbar navbar-expand-lg navbar-light bg-info ">
        <a href="<?= $router->url('accueil')?>" class="navbar-brand m-2">Mon super blog</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="<?= $router->url('accueil')?>">Accueil</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= $router->url('admin_posts')?>">Gérer articles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Gérer catégories</a>
                </li>   
            </ul>
        </div>  
    </nav>

    <div class="container mt-4">
        <?= $content ?>
    </div>

    <footer class="text-light bg-info pt-4 footer mt-auto">
        <div class="container">
            <?php if (defined('DEBUG_TIME')): ?>
            Page générée en <?= round (1000 * (microtime(true) - DEBUG_TIME)) ?> ms
            <?php endif; ?>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>