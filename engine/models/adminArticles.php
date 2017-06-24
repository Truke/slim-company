<?php

class AdminArticles extends Admin
{
    private $_sqlGetArticlesCnt = 'SELECT COUNT(*) AS \'count\' FROM `articles`';
    private $_sqlGetArticlesCatCnt = 'SELECT COUNT(*) AS \'count\' FROM `articles` WHERE `parent`=?;';
    private $_sqlGetArticles = 'SELECT `id`,`uri`,`title`,`parent` FROM `articles` LIMIT :l1,:l2;';
    private $_sqlGetArticlesCat = 'SELECT `id`,`uri`,`title`,`parent` FROM `articles` WHERE `parent`=:cat LIMIT :l1,:l2;';
    private $_sqlGetArticlesCategories = 'SELECT `id`,`title` FROM `categories`';
    private $_sqlDeleteArticle = 'DELETE FROM `articles` WHERE `id` = ? LIMIT 1;';
    private $_sqlGetArticle = 'SELECT * FROM `articles` WHERE `id`=? LIMIT 1;';
    private $_sqlUpdateArticle = 'UPDATE `articles` SET :values WHERE `id`=?;';
    private $_sqlInsertArticle = 'INSERT INTO `articles` SET :values';


    public function getArticles($category=null, $page = 0)
    {
        // get articles count
        if(is_null($category)) {
            $stm = $this->_pdo->prepare($this->_sqlGetArticlesCnt);
        }else{
            $stm = $this->_pdo->prepare($this->_sqlGetArticlesCatCnt);
            $stm->bindParam(1, $category, PDO::PARAM_INT);
        }

        $stm->execute();
        $res['count'] = $stm->fetchColumn();
        if ($res['count'] === false)
            return $res;

        // calculate pages
        $res['pagination'] = $this->calcPages($page, $res['count']);

        // get articles
        $limit = [$res['pagination']['current'] * $this->perpage, $this->perpage];

        if(is_null($category)) {
            $stm = $this->_pdo->prepare($this->_sqlGetArticles);
        }else{
            $stm = $this->_pdo->prepare($this->_sqlGetArticlesCat);
            $stm->bindParam(':cat', $category, PDO::PARAM_INT);
        }

        $stm->bindParam(':l1', $limit[0], PDO::PARAM_INT);
        $stm->bindParam(':l2', $limit[1], PDO::PARAM_INT);

        // echo $stm->interpolateQuery();die();

        $stm->execute();
        $res['data'] = $stm->fetchAll();

        // get categories list
        $stm = $this->_pdo->prepare($this->_sqlGetArticlesCategories);
        $stm->execute();
        $res['cats'] = $stm->fetchAll(PDO::FETCH_KEY_PAIR);

        return $res;
    }

    public function articleDelete($id){
        $stm = $this->_pdo->prepare($this->_sqlDeleteArticle);
        $stm->bindParam(1, $id, PDO::PARAM_INT);
        if($stm->execute() === false)
            return '删除失败';
        else
            return '删除成功';
    }

    public function articleEdit($id){
        $stm = $this->_pdo->prepare($this->_sqlGetArticle);
        $stm->bindParam(1, $id, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch();
    }

    public function getCategoriesPairs(){
        $stm = $this->_pdo->prepare($this->_sqlGetArticlesCategories);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    public function articleAdd(){
        return  [
            'uri'=>'',
            'title'=>'',
            'meta_title'=>'',
            'meta_description'=>'',
            'meta_keywords'=>'',
            'text'=>'',
            'parent'=>''
        ];
    }

    public function saveArticle($id,$data){
        $this->_pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        if(is_null($id)){
            $data['published'] = date("Y-m-d H:i:s",time());

            $stm = $this->_pdo->prepare(str_replace(':values', $this->pdoSet($data), $this->_sqlInsertArticle));
            $r = $stm->execute();
        }else{
            $stm = $this->_pdo->prepare(str_replace(':values', $this->pdoSet($data), $this->_sqlUpdateArticle));
            $stm->bindParam(1, $id, PDO::PARAM_INT);
            $r = $stm->execute();
        }
        //echo $stm->interpolateQuery();die();

        if($r === false){
            return $stm->errorInfo()[2];
        }else{
            return true;
        }

    }

}