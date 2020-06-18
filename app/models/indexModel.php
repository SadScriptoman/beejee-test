
<?
class indexModel extends Model{

    public $allowedTags = Array('br', 'strong', 'b', 'i');

    public function addItem($array){
        $db = $this->getDB();
        if($db){
            extract($array);
            $text = htmlspecialchars(strip_tags($text, $this->allowedTags));
            $email = htmlspecialchars(strip_tags($email, $this->allowedTags));
            $name = htmlspecialchars(strip_tags($name, $this->allowedTags));
            $str = $db->prepare("INSERT INTO todos (name, email, text) VALUES ('$name', '$email', '$text')");
            if (!$str->execute()){
                throw new Exception('indexModel::addItem(): запрос не был выполнен! Возможно, отсутвуют некоторые параметры.');
            }
            return true;
        }else{
            throw new Exception('indexModel::addItem(): нет базы данных!');
        }
        return false;
    }

    public function deleteItem($id){
        if($this->application->logged()){
            $db = $this->getDB();
            if($db){
                $str = $db->prepare("DELETE FROM todos WHERE id = $id");
                if (!$str->execute()){
                    throw new Exception('indexModel::deleteItem(): запрос не был выполнен!');
                }
                return true;
            }else{
                throw new Exception('indexModel::deleteItem(): нет базы данных!');
            }
        }
        return false;
    }

    public function editItem($array){
        if($this->application->logged()){
            extract($array);
            if ($id){
                $db = $this->getDB();
                $dateEdited = "dateEdited = '".date('Y-m-d H:i:s')."'";
                $text = htmlspecialchars(strip_tags($text, $this->allowedTags));
                $email = htmlspecialchars(strip_tags($email, $this->allowedTags));
                $name = htmlspecialchars(strip_tags($name, $this->allowedTags));
                
                if($db){
                    $str = $db->prepare("UPDATE todos SET name = '$name', email = '$email', text = '$text', $dateEdited WHERE id = $id");
                    if (!$str->execute()){
                        throw new Exception('indexModel::editItem(): запрос не был выполнен! Возможно, отсутвуют некоторые параметры.');
                    }
                    return true;
                }else{
                    throw new Exception('indexModel::editItem(): нет базы данных!');
                }
            }else{
                throw new Exception('indexModel::editItem(): нет id элемента!');
            }
        }
        return false;
    }

    public function switchStates($id){
        if($this->application->logged()){
            if ($id){
                $db = $this->getDB();
                if($db){
                    $str = $db->prepare("SELECT completed FROM todos WHERE id = $id");
                    if (!$str->execute()){
                        throw new Exception('indexModel::switchStates(): первый запрос не был выполнен!');
                    }
                    $result = $str->fetch(PDO::FETCH_ASSOC);
                    if ($result['completed']){
                        $completed = 0;
                    }else{
                        $completed = 1;
                    }
                    $str = $db->prepare("UPDATE todos SET completed = $completed WHERE id = $id");
                    if (!$str->execute()){
                        throw new Exception('indexModel::switchStates(): второй запрос не был выполнен!');
                    }
                    return true;
                }else{
                    throw new Exception('indexModel::switchStates(): нет базы данных!');
                }
            }else{
                throw new Exception('indexModel::switchStates(): нет id элемента!');
            }
        }
        return false;
    }

    public function getData($search = NULL, $page = 0, $limit = 3, $count = false){	
        $db = $this->getDB();
        $offset = ($page-1) * $limit; 
        if($db){
            if ($search){
                $searchUnscaped = preg_replace("/[()\-\+\=]/", '', $search); 
                $searchQuery = '+*'.preg_replace("/\s+/", '*+*', $searchUnscaped)."*";

                if($count){
                    $str = $db->prepare("SELECT COUNT(id) FROM todos WHERE
                    MATCH(`name`, `email`)
                    AGAINST('$searchQuery' IN BOOLEAN MODE)");
                }else{
                    $str = $db->prepare("SELECT * FROM todos WHERE
                    MATCH(`name`, `email`)
                    AGAINST('$searchQuery' IN BOOLEAN MODE) LIMIT $offset, $limit");
                }

            }else{
                if($count){
                    $str = $db->prepare("SELECT COUNT(id) FROM todos ORDER BY id");

                }else{
                    $str = $db->prepare("SELECT * FROM todos ORDER BY id DESC LIMIT $offset, $limit");
                }
            }
            if ($str->execute()){
                $result = $str->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            }else{
                throw new Exception('indexModel::getData(): запрос не был выполнен!');
            }
        }else{
            throw new Exception('indexModel::getData(): нет базы данных!');
        }
        return false;
    }

    public function getCount($search = NULL, $page = 0, $limit = 3){
        return $this->getData($search, $page, $limit, true);
    }

    
}