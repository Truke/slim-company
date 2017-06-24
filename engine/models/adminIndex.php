<?php

class AdminIndex extends Admin
{

    private $_sqlGetArticlesCatCnt = 'SELECT COUNT(*) AS \'count\' FROM `articles` WHERE `parent`=?;';
    private $_sqlGetSystem = 'SELECT * FROM `system`';
    private $_sqlUpdateSystem = 'UPDATE `system` SET :values';
    /**
     * Get cont for index page
     */
    public function getArticlesCatCnt($category)
    {
        $stm = $this->_pdo->prepare($this->_sqlGetArticlesCatCnt);
        $stm->bindParam(1, $category, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchColumn();
    }

    public function getSystem()
    {
        $stm = $this->_pdo->prepare($this->_sqlGetSystem);
        $stm->execute();
        return $stm->fetch();
    }

    public function saveSystem($data)
    {
        $stm = $this->_pdo->prepare(str_replace(':values', $this->pdoSet($data), $this->_sqlUpdateSystem));
        return $stm->execute();
    }
    
    public function FileLastLines($filename,$n){
      if(!$fp=fopen($filename,'r')){
        echo "打开文件失败，请检查文件路径是否正确，路径和文件名不要包含中文";
        return false;
      }
      $pos=-2;
      $eof="";
      $arr=array();
      while($n>0){
        while($eof!="\n"){
          if(!fseek($fp,$pos,SEEK_END)){
            $eof=fgetc($fp);
            $pos--;
          }else{
            break;
          }
        }
        array_push($arr,fgets($fp));
        // $str.=fgets($fp).'<br>';
        $eof="";
        $n--;
      }
      return $arr;
    }
}