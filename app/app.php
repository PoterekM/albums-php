<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Album.php";

    $app - new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=music';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->regiseter(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('album.html.twig', array('albums' => Album::getAll()));
    });

    $app->post("/albums", function() use ($app) {
        $album = new Album($_POST['album']);
        $album->save();
        return $app['twig']->render('add_album.html.twig', array('newtask' => $task));
    });

    $app->post("/delete_albums", function() use ($app) {
        Album::deleteAll();
        return $app['twig']->render('delete_albums.html.twig');
    });

    return $app;
 ?>
