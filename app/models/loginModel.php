<?

class loginModel extends Model{

    public function getData($login = NULL){	
        $db = $this->getDB();
        if($db){
            if ($login){
                $str = $db->prepare("SELECT * FROM users WHERE login = $login OR email = $login");
            }else{
                $str = $db->prepare("SELECT * FROM users");
            }
            if ($str->execute()){
                $result = $str->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            }else{
                throw new Exception('loginModel::getData(): запрос не был выполнен!');
            }
        }else{
            throw new Exception('loginModel::getData(): нет базы данных!');
        }
    }

}