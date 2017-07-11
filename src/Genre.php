<?php
    class Genre
    {
        private $genre;
        private $id;

        function __construct($genre, $id = null)
        {
            $this->genre = $genre;
            $this->id = $id;
        }

        function setGenre($new_genre)
        {
            $this->genre = (string) $new_genre;
        }

        function getGenre()
        {
            return $this->genre;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO genre (name) VALUES ('{$this->getGenre()}')");
            if ($executed) {
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }

        static function getAll()
        {
            $returned_genres = $GLOBALS['DB']->query("SELECT * FROM genre;");
            $genres = array();
            foreach($returned_genres as $genre) {
                $genre_name = $genre['name'];
                $id = $genre['id'];
                $new_genre = new Genre($genre_name, $id);
                array_push($genres, $new_genre);
            }
            return $genres;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM genre;");
        }

        static function find($search_id)
        {
            $found_genre = null;
            $returned_genres = $GLOBALS['DB']->prepare("SELECT * FROM genre WHERE id = :id");
            $returned_genres->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_genres->execute();
            foreach($returned_genres as $genre) {
                $genre_name = $genre['name'];
                $genre_id = $genre['id'];
                if ($genre_id == $search_id) {
                    $found_genre = new Genre($genre_name, $genre_id);
                }
            }
            return $found_genre;
        }
    }





 ?>
