<?php
  require_once 'Api.php';
  require_once 'db/categories.php';

  class UsersApi extends Api
  {
    public $apiName = 'categories';

    /**
     * Метод GET
     * Вывод списка всех записей
     * http://ДОМЕН/categories
     * @return string
     * http://api/api/categories
     */
    public function indexAction()
    {
      $db = new Categories();
      $categories = $db->getAll();
      if($categories){
        return $this->response($categories, 200);
      }
      return $this->response('Data not found', 404);
    }

    /**
     * Метод GET
     * Просмотр отдельной записи (по id)
     * http://ДОМЕН/categories/1
     * @return string
     * http://api/api/categories/1
     */
    public function viewAction()
    {
      //id должен быть первым параметром после /users/x
      $id = array_shift($this->requestUri);

      if($id){
        $db = new Categories();
        $category = $db->getById($id);
        
        if($category){
          return $this->response($category, 200);
        }
        return $this->response('Data not found', 404);
      }
    }

    /**
     * Метод POST
     * Создание новой записи
     * http://ДОМЕН/categories + параметры запроса title, categ
     * http://api/api/categories/title?title=sdfg&categ=12345
     * @return string
     */
    public function createAction()
    {
      $title = $this->requestParams['title'] ?? '';
      $categ = $this->requestParams['categ'] ?? '';

      if($title && $categ){
        $db = new Categories();
        $category = $db->setCategory($title, $categ);

        if($category){
          return $this->response('Data saved.', 200);
        }
      }

      return $this->response("Saving error", 500);
    }

    /**
     * Метод PUT
     * Обновление отдельной записи (по ее id)
     * http://ДОМЕН/categories/1 + параметры запроса title, categ
     * http://api/api/categories/3?title=sdsdf&categ=12345
     * @return string
     */
    public function updateAction()
    {
      $parse_url = parse_url($this->requestUri[0]);
      $categoryId = $parse_url['path'] ?? null;

      $db = new Categories();
      $category = $db->getById($categoryId);

      if(!$categoryId || is_null($category)){
        return $this->response("Category with id=$categoryId not found", 404);
      }

      $title = $this->requestParams['title'] ?? '';
      $categ = $this->requestParams['categ'] ?? '';

      if($title && $categ){
        if($db->updateById($categoryId, $title, $categ)){
          return $this->response('Data updated.', 200);
        }
      }
      return $this->response("Update error", 400);
    }

    /**
     * Метод DELETE
     * Удаление отдельной записи (по ее id)
     * http://ДОМЕН/categories/1
     * @return string
     */
    public function deleteAction()
    {
      $parse_url = parse_url($this->requestUri[0]);
      $categoryId = $parse_url['path'] ?? null;

      $db = new Categories();
      $category = $db->getById($categoryId);
      
      if(!$categoryId || !$category){
        return $this->response("User with id=$categoryId not found", 404);
      }

      if($db->deleteById($categoryId)){
        return $this->response('Data deleted.', 200);
      }
      return $this->response("Delete error", 500);
    }
  }
?>
