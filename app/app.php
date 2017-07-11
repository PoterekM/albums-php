<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Album.php";
    require_once __DIR__."/../src/Genre.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=music';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('genres' => Genre::getAll()));
    });

    $app->get("/albums", function() use ($app) {
        return $app['twig']->render('albums.html.twig', array('albums' => Album::getAll()));
    });

    $app->get("/genres", function() use ($app) {
        return $app['twig']->render('genres.html.twig', array('genres' => Genre::getAll()));
    });

    $app->post("/albums", function() use ($app) {
        $album_name = $_POST['description'];
        $genre_id = $_POST['genre_id'];
        $album = new Album($album_name, $genre_id);
        $album->save();
        $genre = Genre::find($genre_id);
        return $app['twig']->render('genre.html.twig', array('genre' => $genre, 'albums' => $genre->getAlbums()));
    });

    $app->post("/delete_albums", function() use ($app) {
        Album::deleteAll();
        return $app['twig']->render('delete_albums.html.twig');
    });

    $app->post("/genres", function() use ($app) {
        $genre = new Genre($_POST['name']);
        $genre->save();
        return $app['twig']->render('index.html.twig', array('genres' => Genre::getAll()));
    });

    $app->get("/genres/{id}", function($id) use ($app) {
        $genre = Genre::find($id);
        return $app['twig']->render('genre.html.twig', array('genre' => $genre, 'albums' => $genre->getAlbums()));
    });

    $app->post("/delete_genres", function() use ($app) {
        Genre::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    return $app;
 ?>
