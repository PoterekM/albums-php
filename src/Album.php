<?php
    class Album
    {
        private $album_name;
        private $genre_id;
        private $id;

        function __construct($album_name, $genre_id, $id = null)
        {
            $this->album_name = $album_name;
            $this->genre_id = $genre_id;
            $this->id = $id;
        }

        function setAlbumName($new_album_name)
        {
            $this->album_name = (string) $new_album_name;
        }

        function getAlbumName()
        {
            return $this->album_name;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO albums (description, genre_id) VALUES ('{$this->getAlbumName()}', {$this->getGenreId()});");
            if ($executed) {
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }

        static function getAll()
        {
            $returned_albums = $GLOBALS['DB']->query("SELECT * FROM albums;");
            $albums = array();
            foreach($returned_albums as $album) {
                $album_name = $album['description'];
                $id = $album['id'];
                $genre_id = $album['genre_id'];
                $new_album = new Album($album_name, $genre_id, $id);
                array_push($albums, $new_album);
            }
            return $albums;
        }

        static function deleteAll()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM albums;");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        function getId()
        {
            return $this->id;
        }

        function getGenreId()
        {
            return $this->genre_id;
        }

        static function find($search_id)
        {
            $returned_albums = $GLOBALS['DB']->prepare("SELECT * FROM albums WHERE id = :id");
            $returned_albums->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_albums->execute();
            foreach($returned_albums as $album) {
                $album_name = $album['description'];
                $album_id = $album['id'];
                $genre_id = $album['genre_id'];
                if ($album_id == $search_id) {
                    $found_album = new Album($album_name, $genre_id, $album_id);
                }
            }
            return $found_album;
        }

    }
 ?>
