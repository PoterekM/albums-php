<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Genre.php";
    require_once "src/Album.php";

    $server = 'mysql:host=localhost:8889;dbname=music_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class GenreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Genre::deleteAll();
            Album::deleteAll();
        }

        function testGetGenre()
        {
            $genre = "ambient";
            $test_genre = new Genre($genre);

            $result = $test_genre->getGenre();

            $this->assertEquals($genre, $result);
        }

        function testSave()
        {
            $genre = "Rock n Roll";
            $test_genre = new Genre($genre);

            $executed = $test_genre->save();

            $this->assertTrue($executed, "Category not successfully saved to database");
        }

        function testGetId()
        {
            $genre = "Classical";
            $test_genre = new Genre($genre);
            $test_genre->save();

            $result = $test_genre->getId();

            $this->assertEquals(true, is_numeric($result));
        }

        function testGetAll()
        {
            $genre_1 = "Hip/hop";
            $genre_2 = "R&b";
            $test_genre_1 = new Genre($genre_1);
            $test_genre_1->save();
            $test_genre_2 = new Genre($genre_2);
            $test_genre_2->save();

            $result = Genre::getAll();

            $this->assertEquals([$test_genre_1, $test_genre_2], $result);
        }

        function testDeleteAll()
        {
            $genre_1 = "Techno";
            $genre_2 = "Harsh Noise";
            $test_genre_1 = new Genre($genre_1);
            $test_genre_1->save();
            $test_genre_2 = new Genre($genre_2);
            $test_genre_2->save();

            Genre::deleteAll();
            $result = Genre::getAll();

            $this->assertEquals([], $result);
        }

        function testFind()
        {
            $genre_1 = "Techno";
            $genre_2 = "Harsh Noise";
            $test_genre_1 = new Genre($genre_1);
            $test_genre_1->save();
            $test_genre_2 = new Genre($genre_2);
            $test_genre_2->save();

            $result = Genre::find($test_genre_1->getId());

            $this->assertEquals($test_genre_1, $result);
        }

        function testGetAlbums()
        {
            $genre = "Acid House";
            $test_genre = new Genre($genre);
            $test_genre->save();

            $test_genre_id = $test_genre->getId();

            $album = "Slim Season 3";
            $test_album = new Album($album, $test_genre_id);
            $test_album->save();

            $album2 = "Rich Forever 3";
            $test_album_2 = new Album($album2, $test_genre_id);
            $test_album_2->save();

            $result = $test_genre->getAlbums();

            $this->assertEquals([$test_album, $test_album_2], $result);
        }


    }

 ?>
