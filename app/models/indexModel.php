
<?
class indexModel extends Model{

    public function getData($search = NULL, $page = 0, $limit = 3){	
		$db = $this->getDB();
        if($db){
            if ($search){
                $search_unscaped = preg_replace("/[()\-\+\=]/", '', $search); 
                $search_query = '+*'.preg_replace("/\s+/", '*+*', $search_unscaped)."*";

                $str = $db->prepare("SELECT * FROM todos WHERE
                MATCH(`name`, `email`)
                AGAINST('$search_query' IN BOOLEAN MODE)");

            }else{
                $str = $db->prepare("SELECT * FROM todos ORDER BY dateCreated");
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
    }
    
}