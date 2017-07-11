<?php
    class Album
    {
        private $album_name;
        private $id;

        function __construct($album_name, $id = null)
        {
            $this->album_name = $album_name;
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
            $executed = $GLOBALS['DB']->exec("INSERT INTO albums (description) VALUES ('{$this->getAlbumName()}');");
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
                $new_album = new Album($album_name, $id);
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

        static function find($search_id)
        {
            $returned_albums = $GLOBALS['DB']->prepare("SELECT * FROM albums WHERE id = :id");
            $returned_albums->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_albums->execute();
            foreach($returned_albums as $album) {
                $album_name = $album['description'];
                $album_id = $album['id'];
                if ($album_id == $search_id) {
                    $found_album = new Album($album_name, $album_id);
                }
            }
            return $found_album;
        }

    }
 ?>
