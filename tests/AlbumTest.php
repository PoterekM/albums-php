<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */


    require_once "src/Album.php";
    require_once "src/Genre.php";


    $server = 'mysql:host=localhost:8889;dbname=music_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AlbumTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Album::deleteAll();
            Genre::deleteAll();
        }

        function test_save()
        {
            $genre = "Electronic";
            $test_genre = new Genre($genre);
            $test_genre->save();


            $album_name = "Channel Orange";
            $genre_id = $test_genre->getId();
            $test_album = new Album($album_name, $genre_id);

            $executed = $test_album->save();

            $this->assertTrue($executed, "Task not successfully saved to database");
        }

        function testGetAll()
        {
            $genre = "Folk";
            $test_genre = new Genre($genre);
            $test_genre->save();
            $genre_id = $test_genre->getId();


            $album_1 = "DrukQs";
            $album_2 = "Back in Black";
            $test_album = new Album($album_1, $genre_id);
            $test_album->save();
            $test_album_2 = new Album($album_2, $genre_id);
            $test_album_2->save();

            $result = Album::getAll();

            $this->assertEquals([$test_album, $test_album_2], $result);
        }

        function testDeleteAll()
        {
            $genre = "Butt-Rock";
            $test_genre = new Genre($genre);
            $test_genre->save();
            $genre_id = $test_genre->getId();

            $album_1 = "DrukQs";
            $album_2 = "Back in Black";
            $test_album = new Album($album_1, $genre_id);
            $test_album->save();
            $test_album_2 = new Album($album_2, $genre_id);
            $test_album_2->save();

            Album::deleteAll();

            $result = Album::getAll();
            $this->assertEquals([], $result);
        }

        function testGetId()
        {
            $name = "Rap";
            $test_genre = new Genre($name);
            $test_genre->save();

            $album = "Birds in the Trap Sing Brian Mcknight";
            $genre_id = $test_genre->getId();
            $test_album = new Album($album, $genre_id);
            $test_album->save();


            $result = $test_album->getId();

            $this->assertEquals(true, is_numeric($result));
        }

        function testGetGenreId()
        {
            $genre = "Country";
            $test_genre = new Genre($genre);
            $test_genre->save();

            $genre_id = $test_genre->getId();
            $album = "Welcome to the Jungle";
            $test_album = new Album($album, $genre_id);
            $test_album->save();

            $result = $test_album->getGenreId();

            $this->assertEquals($genre_id, $result);
        }

        function testFind()
        {
            $genre = "Jazz";
            $test_genre = new Genre($genre);
            $test_genre->save();
            $genre_id = $test_genre->getId();

            $album_1 = "Take Care";
            $album_2 = "Big Johnny";
            $test_album_1 = new Album($album_1, $genre_id);
            $test_album_1->save();
            $test_album_2 = new Album($album_2, $genre_id);
            $test_album_2->save();

            $id = $test_album_1->getId();
            $result = Album::find($id);

            $this->assertEquals($test_album_1, $result);
        }





    }


 ?>
