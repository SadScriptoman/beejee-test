<?
class Buffer{
    function __construct()
    {
        $this->start();
        register_shutdown_function(array($this, 'end'));
    }
 
    public function start()
    {
        ob_start();
    }
 
    public function end()
    {
        if(ob_get_level() > 1)
        {
            $data = ob_get_contents();
            ob_end_clean();
            
            $this->insertContent($data);
            
            echo $data;
        }
    }
 
    function insertContent(&$data)
    {
        if(!empty($this->buffered))
        {
            foreach($this->buffered as $contentID => $contentData)
            {
                $search[] = '<!--'.$contentID.'-->';
            }
 
            $data = str_replace($search, $this->buffered, $data);
        }
    }
 
    function show($contentID)
    {
        if(ob_get_level() > 1)
        {
            echo '<!--'.$contentID.'-->';
        }
    }
    
    function set($contentID, $data)
    {
        $this->buffered[$contentID] = $data;
    }
    
 
}