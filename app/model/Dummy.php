<?php

namespace App\Model;

class Dummy extends AbstractModel
{
    static $table;

    public function upload_subjects()
    {
        static::$table = "subjects";
        $arr = file_get_contents(__DIR__ . "/../files/mock_subjects.json", FILE_USE_INCLUDE_PATH);
        $arr = json_decode($arr, true);
        self::clear_table();
        $db = self::get_db();
        foreach ($arr as $key => $value) {
            $q = "INSERT INTO " . static::$table . " (" . join(", ", array_keys($value)) . ") VALUES ('" . join("', '", array_values($value)). "')";
            if ($result = $db->sql($q)) {
                echo "success";
                } else echo "failure";
        }
    }

    private function clear_article_duplicate_titles()
    {
        $arr = file_get_contents(__DIR__ . "/../files/mock_articles.json", FILE_USE_INCLUDE_PATH);
        $arr = json_decode($arr, true);

        $titles_array=[];
        foreach ($arr as $art_index => $art_el) {
            foreach ($art_el as $key => $value) {
                if ($key =="title") {
                    $titles_array[] = $value;
                }
            }
        }
        $sorted = array_unique($titles_array);
        // var_dump($sorted);

        foreach ($arr as $key => $value) {
            foreach ($sorted as $key2 => $value2) {
                if ($value["title"] == $value2) {
                    $arr_mod[] = $value;
                    unset($sorted[$key2]);
                }
            }
        }

        file_put_contents(__DIR__ . "/../files/mock_articles-mod.json", json_encode($arr_mod) );

        return $arr_mod;
    }   

    public function upload_articles()
    {
        static::$table = "articles";

        if (!file_exists(__DIR__ . "/../files/mock_articles-mod.json")) {
            $arr = $this->clear_article_duplicate_titles();
        } else {
            $arr = file_get_contents(__DIR__ . "/../files/mock_articles-mod.json", FILE_USE_INCLUDE_PATH);
            $arr = json_decode($arr, true);
        }

        self::clear_table();
        $db = self::get_db();

        foreach ($arr as $key => $value) {
            $q = "INSERT INTO " . static::$table . " (" . join(", ", array_keys($value)) . ") VALUES ('" . join("', '", array_values($value)). "')";
            if ($result = $db->sql($q)) {
                echo "success";
                } else echo "failure";
        }
    }

    public function upload_users()
      {
        static::$table = "users";
        $arr = file_get_contents(__DIR__ . "/../files/mock_users.json", FILE_USE_INCLUDE_PATH);
        $arr = json_decode($arr, true);
        self::clear_table();
        foreach ($arr as $key => $value) {
            $user = new User();
            $user->name = $value[name];
            $user->password = $value[password];
            $user->admin = $value[admin];
            $user->create();
        }
    }

    public function upload_comments()
    {
       static::$table = "comments";
        $arr = file_get_contents(__DIR__ . "/../files/mock_comments.json", FILE_USE_INCLUDE_PATH);
        $arr = json_decode($arr, true);
        self::clear_table();
        $db = self::get_db();
        foreach ($arr as $key => $value) {
            $q = "INSERT INTO " . static::$table . " (" . join(", ", array_keys($value)) . ") VALUES ('" . join("', '", array_values($value)). "')";
            if ($result = $db->sql($q)) {
                echo "success";
                } else echo "failure";
        } 
    }

}
