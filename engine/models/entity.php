<?php

class Entity
{

    private $_pdo;
    private static $link = null;
    private $perpage = 10;
    private $_sqlGetIndex = 'SELECT * FROM `system`';
    private $_sqlGetSlides = 'SELECT * FROM `articles` WHERE `parent` = 2';
    private $_sqlGetServes = 'SELECT * FROM `articles` WHERE `parent` = 3';
    private $_sqlGetSolutions = 'SELECT * FROM `articles` WHERE `parent` = 4 AND `sort` = ?';
    private $_sqlGetProducts = 'SELECT * FROM `articles` WHERE `parent` = 5';
    private $_sqlGetCases = 'SELECT * FROM `articles` WHERE `parent` = 6';
    private $_sqlGetServices = 'SELECT * FROM `articles` WHERE `parent` = 7';
    private $_sqlGetNews = 'SELECT * FROM `articles` WHERE `parent` = 8';
    private $_sqlGetRecruits = 'SELECT * FROM `articles` WHERE `parent` = 9';

    private $_sqlGetArticle = 'SELECT * FROM `articles` WHERE `uri` = ? LIMIT 1;';

    private $_sqlGetCategory = "SELECT *, (SELECT COUNT(*) FROM `articles` b WHERE b.`parent` = a.`id`) AS 'posts_count' FROM `categories` as a WHERE `uri` = ? LIMIT 1;";
    private $_sqlGetCategoryPosts = "SELECT `uri`, `title`, CONCAT(TRIM(LEFT(`text`,200)),'...') AS `text` FROM `articles` WHERE `parent` = ? LIMIT ?,?;";

    

    private $_sqlGetMenu = 'SELECT CONCAT(\'/\',`uri`,\'/\') as \'uri\', `title` FROM `categories`';

    /**
     * Constructor
     */
    public function __construct($_pdo)
    {
        if (!is_null(self::$link))
            return self::$link;

        self::$link = $this;
        $this->_pdo = $_pdo;
    }

    public function getSlides(){
        $stm = $this->_pdo->prepare($this->_sqlGetSlides);
        $stm->setFetchMode(PDO::PARAM_STR);
        $stm->execute();
        return $stm->fetchAll();
    }
    public function getServes(){
        $stm = $this->_pdo->prepare($this->_sqlGetServes);
        $stm->setFetchMode(PDO::PARAM_STR);
        $stm->execute();
        return $stm->fetchAll();
    }
    public function getSolutions($type){
        $stm = $this->_pdo->prepare($this->_sqlGetSolutions);
        $stm->bindParam(1, $type, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll();
    }
    public function getProducts(){
        $stm = $this->_pdo->prepare($this->_sqlGetProducts);
        $stm->setFetchMode(PDO::PARAM_STR);
        $stm->execute();
        return $stm->fetchAll();
    }
    public function getCases(){
        $stm = $this->_pdo->prepare($this->_sqlGetCases);
        $stm->setFetchMode(PDO::PARAM_STR);
        $stm->execute();
        return $stm->fetchAll();
    }
    public function getServices(){
        $stm = $this->_pdo->prepare($this->_sqlGetServices);
        $stm->setFetchMode(PDO::PARAM_STR);
        $stm->execute();
        return $stm->fetchAll();
    }
    public function getNews(){
        $stm = $this->_pdo->prepare($this->_sqlGetNews);
        $stm->setFetchMode(PDO::PARAM_STR);
        $stm->execute();
        return $stm->fetchAll();
    }
    public function getRecruits(){
        $stm = $this->_pdo->prepare($this->_sqlGetRecruits);
        $stm->setFetchMode(PDO::PARAM_STR);
        $stm->execute();
        return $stm->fetchAll();
    }

    /**
     * Get menu for site
     */
    public function getMenu()
    {
        $stm = $this->_pdo->prepare($this->_sqlGetMenu);
        $stm->setFetchMode(PDO::FETCH_NUM);
        $stm->execute();
        $res = $stm->fetchAll();
        if (!is_array($res))
            $res = [];
        array_unshift($res, ['/', 'Home']);
        return $res;
    }

    /**
     * Get article by uri string
     */
    public function getArticle($uri)
    {
        $stm = $this->_pdo->prepare($this->_sqlGetArticle);
        $stm->bindParam(1, $uri, PDO::PARAM_STR);
        $stm->execute();
        return $stm->fetch();
    }

    /**
     * Get article for index page
     */
    public function getIndex()
    {
        $stm = $this->_pdo->prepare($this->_sqlGetIndex);
        $stm->execute();
        return $stm->fetch();
    }

    /**
     * Get category by uri string
     */
    public function getCategory($uri, $page = 0)
    {

        // get general category data
        $stm = $this->_pdo->prepare($this->_sqlGetCategory);
        $stm->bindParam(1, $uri, PDO::PARAM_STR);
        $stm->execute();
        $res = $stm->fetch();
        if (!is_array($res))
            return $res;

        // calculate pages
        $res['pagination'] = $this->calcPages($page, $res['posts_count']);

        // get posts
        $limit = [$res['pagination']['current'] * $this->perpage, $this->perpage];

        $stm = $this->_pdo->prepare($this->_sqlGetCategoryPosts);
        $stm->bindParam(1, $res['id'], PDO::PARAM_INT);
        $stm->bindParam(2, $limit[0], PDO::PARAM_INT);
        $stm->bindParam(3, $limit[1], PDO::PARAM_INT);

        // echo $stm->interpolateQuery();die();

        $stm->execute();
        $res['posts'] = $stm->fetchAll();
        foreach ($res['posts'] as $k => $v) {
            $res['posts'][$k]['text'] = strip_tags($res['posts'][$k]['text']);
        }

        return $res;
    }

    private function calcPages($current, $count)
    {
        $max_page = ceil($count / $this->perpage) - 1;
        if ($current < 0)
            $current = 0;
        elseif ($current > $max_page)
            $current = $max_page;
        $pages = [];

        if ($max_page > 0)
            for ($i = 0; $i <= $max_page; $i++)
                $pages[$i] = $i + 1;

        return [
            'pages' => $pages,
            'current' => $current,
            'max' => $max_page,
            'count' => $count
        ];
    }
}