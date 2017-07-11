<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */


    require_once "src/Album.php";

    $server = 'mysql:host=localhost:8889;dbname=music_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AlbumTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Album::deleteAll();
        }

        function test_save()
        {
            $album_name = "Channel Orange";
            $test_album = new Album($album_name);

            $executed = $test_album->save();

            $this->assertTrue($executed, "Task not successfully saved to database");
        }

        function testGetAll()
        {
            $album_1 = "DrukQs";
            $album_2 = "Back in Black";
            $test_album = new Album($album_1);
            $test_album->save();
            $test_album_2 = new Album($album_2);
            $test_album_2->save();

            $result = Album::getAll();

            $this->assertEquals([$test_album, $test_album_2], $result);
        }

        function testDeleteAll()
        {
            $album_1 = "DrukQs";
            $album_2 = "Back in Black";
            $test_album = new Album($album_1);
            $test_album->save();
            $test_album_2 = new Album($album_2);
            $test_album_2->save();

            Album::deleteAll();

            $result = Album::getAll();
            $this->assertEquals([], $result);
        }

        function testGetId()
        {
            $album = "Birds in the Trap Sing Brian Mcknight";
            $test_album = new Album($album);
            $test_album->save();

            $result = $test_album->getId();

            $this->assertTrue(is_numeric($result));
        }

        function testFind()
        {
            $album_1 = "Take Care";
            $album_2 = "Big Johnny";
            $test_album_1 = new Album($album_1);
            $test_album_1->save();
            $test_album_2 = new Album($album_2);
            $test_album_2->save();

            $id = $test_album_1->getId();
            $result = Album::find($id);

            $this->assertEquals($test_album_1, $result);
        }





    }


 ?>
