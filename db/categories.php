<?php
  class Categories {
    public function getAll () {
      //  обращение к свойству объекта
      //  return $this->categories;

      // обращение к БД
      /*
      $host = 'localhost';
      $user = 'root';
      $password = '';
      $db_name = 'test';

      $link = mysqli_connect($host, $user, $password, $db_name) or die(mysqli_error($link));
      mysqli_query($link, "SET NAMES 'utf8'");
      $query = "SELECT * FROM users";
      $result = mysqli_query($link, $query) or die(mysqli_error($link));
      for($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
      
      return $data;
      */

      // обращение к текстовому файлу
      $text  = file_get_contents('db/categories.txt');
      $arr = json_decode($text);
      return $arr;
    }

    public function getById ($id) {
      $text  = file_get_contents('db/categories.txt');
      $arr = json_decode($text);

      $category;
      foreach($arr as $el) {
        $array = (array) $el;
        if($array['id'] == $id) {
          $category = $array;
        }
      }

      return $category;
    }

    public function setCategory($title, $categ) {
      $text = file_get_contents('db/categories.txt');
      $arr = json_decode($text);

      $currentId = 0;
      foreach($arr as $el){
        $array = (array) $el;
        if($array['id'] > $currentId){
          $currentId = $array['id'];
        }
      }

      $currentId++;

      $newEl = 
        [
          'id' => $currentId, 
          'cTitle' => $title, 
          'cCateg' => $categ,
          'cMetaDescription' => 'Мета описание',
          'cDesc' => 'Описание',
          'products' => []
        ];
      
      $object = (object) $newEl;

      $arr[$id] = $object;

      $arr2 = array_values($arr);
      $result = json_encode($arr2);
      file_put_contents('db/categories.txt', $result);

      return true;
    }

    public function updateById($id, $title, $categ) {
      $text = file_get_contents('db/categories.txt');
      $arr = json_decode($text);

      $ind;
      foreach($arr as $key => $el) {
        $array = (array) $el;
        if($array['id'] == $id) {
          $ind = $key;
        }
      }

      $arr2 = (array) $arr[$ind];

      $arr2['cTitle'] = $title;
      $arr2['cCateg'] = $categ;

      $object = (object) $arr2;

      $arr[$ind] = $object;
      $arr2 = array_values($arr);
      $result = json_encode($arr2);
      file_put_contents('db/categories.txt', $result);

      return true;
    }

    public function deleteById($id) {
      $text = file_get_contents('db/categories.txt');
      $arr = json_decode($text);

      $ind;
      foreach($arr as $key => $el) {
        $array = (array) $el;
        if($array['id'] == $id) {
          $ind = $key;
        }
      }

      unset($arr[$ind]);

      $arr2 = array_values($arr);
      $result = json_encode($arr2);

      file_put_contents('db/categories.txt', $result);

      return true;
    }
  }
?>