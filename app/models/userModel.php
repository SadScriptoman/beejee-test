<?

class userModel extends Model{

    public function checkUser($login, $password){	
        $db = $this->getDB();
        if($db){
            $login = htmlspecialchars(strip_tags($login));
            $password = htmlspecialchars(strip_tags($password));
            $str = $db->prepare("SELECT * FROM users WHERE login = '$login' AND password = '$password'");
            if ($str->execute()){
                $result = $str->fetch(PDO::FETCH_ASSOC);
                if ($result) return $result;
                else return false;
            }else{
                throw new Exception('userModel::checkUser(): запрос не был выполнен!');
            }
        }else{
            throw new Exception('userModel::checkUser(): нет базы данных!');
        }
        return false;
    }

    public function authorize($login, $password){	
        $db = $this->getDB();
        if($db){
            if ($result = $this->checkUser($login, $password)){
                setcookie('sessionID', session_id(), time()+86400*7); //сохраняем id сессии на 7 дней
                $_SESSION['user'] = [
                    'login' => $result['login'],
                ];
                return true;
            }
        }else{
            throw new Exception('userModel::authorize(): нет базы данных!');
        }
        return false;
    }

    public function logout(){	
        if (isset($_COOKIE['sessionID'])) {
            session_id($_COOKIE['sessionID']);
            $_COOKIE['sessionID'] = NULL;
            setcookie('sessionID', NULL, time()-86400*7, '/'); //сохраняем id сессии на 7 дней
        }
        session_destroy();
        return true;
    }

}