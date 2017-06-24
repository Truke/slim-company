<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class AdminController
{
    protected $ci;
    private $out;

    public function __construct($ci)
    {
        $this->ci = $ci;
    }

    public function indexAction($request, $response, $args)
    {
        $this->preparer();
        $this->out['menu_active'] = $this->ci->get('router')->pathFor('AdminController:indexAction');
        
        $model = new AdminIndex($this->ci['db']);
        $this->out['solutionscont'] = $model->getArticlesCatCnt(4);
        $this->out['productscont'] = $model->getArticlesCatCnt(5);
        $this->out['casescont'] = $model->getArticlesCatCnt(6);
        $this->out['newscont'] = $model->getArticlesCatCnt(8);
        $this->out['logs'] = $model->FileLastLines($this->ci['settings']['logger']['path'],10);

        session_write_close();

        return $this->ci['response']
            ->withHeader('Content-Type', 'text/html')
            ->write($this->ci->get('twig')->render('admin/index.html', $this->out));
    }
    
    public function systemAction($request, $response, $args)
    {
        if ($request->isPost())
            return $this->systemSaveAction($request, $response, $args);

        $this->preparer();
        $this->out['menu_active'] = $this->ci->get('router')->pathFor('AdminController:systemAction');

        $model = new AdminIndex($this->ci['db']);
        $this->out['data'] = $model->getSystem();
        $this->out['action'] = $this->ci->get('router')->pathFor('AdminController:systemAction');

        session_write_close();

        return $this->ci['response']
            ->withHeader('Content-Type', 'text/html')
            ->write($this->ci->get('twig')->render('admin/system.html', $this->out));
    }


    

    public function categoriesAction($request, $response, $args)
    {
        $this->preparer();
        $router = $this->ci->get('router');
        $this->out['menu_active'] = $router->pathFor('AdminController:categoriesAction');
        $model = new AdminCategories($this->ci['db']);
        if (!isset($args['page']))
            $args['page'] = 0;

        $this->out = array_merge($this->out, $model->getCategories($args['page']));
        $this->out['add_href'] = $router->pathFor('AdminController:categoryAction');
        $this->out['this_route'] = $router->pathFor('AdminController:categoriesAction');
        foreach ($this->out['data'] as $id => $item) {
            $this->out['data'][$id]['b_edit'] = $router->pathFor('AdminController:categoryAction', ['id' => $item['id']]);
            $this->out['data'][$id]['b_delete'] = $router->pathFor('AdminController:categoryAction', ['id' => $item['id']]) . '?c=del';
            $this->out['data'][$id]['b_articles'] = $router->pathFor('AdminController:articlesAction') . '?cat=' . $item['id'];
        }

        session_write_close();
        return $this->ci['response']
            ->withHeader('Content-Type', 'text/html')
            ->write($this->ci->get('twig')->render('admin/categories.html', $this->out));
    }

    public function categoryAction($request, $response, $args)
    {
        if ($request->isPost())
            return $this->categorySaveAction($request, $response, $args);

        $cmd = $request->getQueryParam('c');
        $router = $this->ci->get('router');

        if (isset($args['id']) AND $cmd == 'del') {
            // delete category $args['id'], redirect to categoriesAction
            global $_SESSION;
            if (session_status() == PHP_SESSION_NONE)
                session_start();
            $model = new AdminCategories($this->ci['db']);

            $_SESSION['message'] = $model->categoryDelete($args['id']);

            session_write_close();
            return $response
                ->withStatus(301)
                ->withHeader('Location', $this->ci['siteURI'] . $router->pathFor('AdminController:categoriesAction'));
        }

        $this->preparer();
        $this->out['menu_active'] = $router->pathFor('AdminController:categoriesAction');
        $model = new AdminCategories($this->ci['db']);

        if (isset($args['id'])) {
            // edit category $args['id']
            $this->out['data'] = $model->categoryEdit($args['id']);
            $this->out['action'] = $this->ci->get('router')->pathFor('AdminController:categoryAction', ['id' => $args['id']]);
        } else {
            // add category
            $this->out['data'] = $model->categoryAdd();
            $this->out['action'] = $this->ci->get('router')->pathFor('AdminController:categoryAction');
        }

        session_write_close();
        return $this->ci['response']
            ->withHeader('Content-Type', 'text/html')
            ->write($this->ci->get('twig')->render('admin/category.html', $this->out));
    }

    public function articlesAction($request, $response, $args)
    {
        $this->preparer();
        $category = $request->getQueryParam('cat');
        $router = $this->ci->get('router');
        $this->out['menu_active'] = $router->pathFor('AdminController:articlesAction');
        $model = new AdminArticles($this->ci['db']);
        if (!isset($args['page']))
            $args['page'] = 0;

        $this->out = array_merge($this->out, $model->getArticles($category,$args['page']));
        $this->out['add_href'] = $router->pathFor('AdminController:articleAction');
        $this->out['this_route'] = $router->pathFor('AdminController:articlesAction');
        $this->out['parent'] = $category;
        foreach ($this->out['data'] as $id => $item) {
            $this->out['data'][$id]['b_edit'] = $router->pathFor('AdminController:articleAction', ['id' => $item['id']]);
            $this->out['data'][$id]['b_delete'] = $router->pathFor('AdminController:articleAction', ['id' => $item['id']]) . '?c=del';
        }

        session_write_close();
        return $this->ci['response']
            ->withHeader('Content-Type', 'text/html')
            ->write($this->ci->get('twig')->render('admin/articles.html', $this->out));
    }

    public function articleAction($request, $response, $args)
    {
        if ($request->isPost())
            return $this->articleSaveAction($request, $response, $args);

        $cmd = $request->getQueryParam('c');
        $router = $this->ci->get('router');

        if (isset($args['id']) AND $cmd == 'del') {
            // delete article $args['id'], redirect to articlesAction
            global $_SESSION;
            if (session_status() == PHP_SESSION_NONE)
                session_start();
            $model = new AdminArticles($this->ci['db']);

            $_SESSION['message'] = $model->articleDelete($args['id']);

            session_write_close();
            return $response
                ->withStatus(301)
                ->withHeader('Location', $this->ci['siteURI'] . $router->pathFor('AdminController:articlesAction'));
        }

        $this->preparer();
        $this->out['menu_active'] = $router->pathFor('AdminController:articlesAction');
        $model = new AdminArticles($this->ci['db']);

        if (isset($args['id'])) {
            // edit category $args['id']
            $this->out['data'] = $model->articleEdit($args['id']);
            $this->out['action'] = $this->ci->get('router')->pathFor('AdminController:articleAction', ['id' => $args['id']]);
        } else {
            // add category
            $this->out['data'] = $model->articleAdd();
            $this->out['action'] = $this->ci->get('router')->pathFor('AdminController:articleAction');
        }

        $this->out['cats'] = $model->getCategoriesPairs();

        session_write_close();
        return $this->ci['response']
            ->withHeader('Content-Type', 'text/html')
            ->write($this->ci->get('twig')->render('admin/article.html', $this->out));
    }

    public function uploadAction($request, $response, $args)
    {
        $allPostPutVars = $request->getParsedBody();
        $options = array(
            'upload_dir' => 'files/',
            'upload_url' => 'files/',
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i',
            );
        if($args['id']==='logo'||$args['id']==='thumb'||$args['id']==='img'){
            $options['image_versions'] = array();
        }
        $result = new UploadHandler($options);
        $this->ci->get('logger')->info($_SESSION['user'].'上传了'.$result->response['files'][0]->name.'！');
        return $result;
    }


    // POST UPDATE actions
    public function systemSaveAction($request, $response, $args)
    {
        global $_SESSION;
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        $router = $this->ci->get('router');
        $route = $request->getAttribute('route');

        $data = $request->getParsedBody();
        $required_fields = [
            'title' => 'text',
            'logo'=>'text',
            'meta_title' => 'text',
            'meta_description' => 'text',
            'meta_keywords' => 'text',
            'address' => 'text',
            'email' => 'text',
            'phone' => 'text',
            'about' => 'html'
        ];

        $cleared_data = $this->testPostData($required_fields, $data);

        if ($cleared_data === false) {
            $_SESSION['message'] = '系统异常！';
            return $response
                ->withStatus(301)
                ->withHeader('Location', $this->ci['siteURI'] . $router->pathFor($route->getName()));
        }

        $model = new AdminIndex($this->ci['db']);
        if ($model->saveSystem($cleared_data) === false)
            $_SESSION['message'] = '保存失败，请重新提交！';
        else
            $_SESSION['message'] = '保存成功！';
        $this->ci->get('logger')->info($_SESSION['user'].'修改了系统设置！');
        return $response
            ->withStatus(301)
            ->withHeader('Location', $this->ci['siteURI'] . $router->pathFor($route->getName()));
    }

    

    public function categorySaveAction($request, $response, $args)
    {
        global $_SESSION;

        if (session_status() == PHP_SESSION_NONE)
            session_start();
        $router = $this->ci->get('router');
        $route = $request->getAttribute('route');

        $data = $request->getParsedBody();
        $required_fields = [
            'title' => 'text',
            'uri' => 'text',
            'meta_title' => 'text',
            'meta_description' => 'text',
            'meta_keywords' => 'text'
        ];

        $cleared_data = $this->testPostData($required_fields, $data);

        if ($cleared_data === false) {
            $_SESSION['message'] = '数据异常';
            return $response
                ->withStatus(301)
                ->withHeader('Location', $this->ci['siteURI'] . $router->pathFor($route->getName(),$args));
        }


        $model = new AdminCategories($this->ci['db']);
        $id = isset($args['id'])?intval($args['id']):null;
        $r = $model->saveCategory($id,$cleared_data);

        if ($r !== true) {
            $_SESSION['message'] = $r;
            return $response
                ->withStatus(301)
                ->withHeader('Location', $this->ci['siteURI'] . $router->pathFor($route->getName(),$args));
        }else {
            if($id !=null ){
                $this->ci->get('logger')->info($_SESSION['user'].'修改了模块【'.$data['title'].'】！');
            }else{
                $this->ci->get('logger')->info($_SESSION['user'].'添加了模块【'.$data['title'].'】！');
            }
            $_SESSION['message'] = '已保存';
            return $response
                ->withStatus(301)
                ->withHeader('Location', $this->ci['siteURI'] . $router->pathFor('AdminController:categoriesAction'));
        }
    }

    public function articleSaveAction($request, $response, $args)
    {
        global $_SESSION;

        if (session_status() == PHP_SESSION_NONE)
            session_start();
        $router = $this->ci->get('router');
        $route = $request->getAttribute('route');

        $data = $request->getParsedBody();
        $required_fields = [
            'uri' => 'text',
            'title' => 'text',
            'description' => 'text',
            'content' => 'html',
            'meta_title' => 'text',
            'meta_description' => 'text',
            'meta_keywords' => 'text',
            'parent'=>'int',
            'thumb'=> 'text',
            'img'=> 'text',
            'sort'=>'text',
            'href'=>'text',
            'tag'=>'text',
            'published'=>'text',
        ];

        $cleared_data = $this->testPostData($required_fields, $data);

        if ($cleared_data === false) {
            $_SESSION['message'] = '数据异常！';
            return $response
                ->withStatus(301)
                ->withHeader('Location', $this->ci['siteURI'] . $router->pathFor($route->getName(),$args));
        }
        if($cleared_data['parent'] == 0)
            unset($cleared_data['parent']);

        $model = new AdminArticles($this->ci['db']);
        $id = isset($args['id'])?intval($args['id']):null;
        $r = $model->saveArticle($id,$cleared_data);

        if ($r !== true) {
            $_SESSION['message'] = $r;
            return $response
                ->withStatus(301)
                ->withHeader('Location', $this->ci['siteURI'] . $router->pathFor($route->getName(),$args));
        }else {
            if($id !=null ){
                $this->ci->get('logger')->info($_SESSION['user'].'修改了文章【'.$data['title'].'】！');
            }else{
                $this->ci->get('logger')->info($_SESSION['user'].'添加了文章【'.$data['title'].'】！');
            }
            $_SESSION['message'] = '已保存';
            return $response
                ->withStatus(301)
                ->withHeader('Location', $this->ci['siteURI'] . $router->pathFor('AdminController:articlesAction'));
        }
    }

    /** code executed for all actions in this controller
     */
    public function preparer()
    {
        global $_SESSION;

        if (session_status() == PHP_SESSION_NONE)
            session_start();

        $this->out = [];
        if (isset($_SESSION['message'])) {
            $this->out['message'] = $_SESSION['message'];
            unset($_SESSION['message']);
        }
        $this->out['menu'] = $this->getMenu();
    }

    /** Tests POST data
     * @param $required_fields array    field=>type
     * @param $data array   array of POST data
     * @return array    valid array of parameters or FALSE
     */
    private function testPostData($required_fields, $data)
    {
        $res = [];
        foreach ($required_fields as $name => $type) {
            if (!isset($data[$name]))
                return false;
            switch ($type) {
                case 'text':
                    $res[$name] = trim(strip_tags($data[$name]));
                    break;
                case 'html':
                    $res[$name] = trim($data[$name]);
                    break;
                case 'int':
                    $res[$name] = intval($data[$name]);
                    break;
            }
        }
        return $res;
    }

    /**
     * Get menu for admin panel
     */
    private function getMenu()
    {
        $res = [];
        $router = $this->ci->get('router');
        foreach ($this->ci['routes'] as $name => $item)
            if (isset($item['inMenu']) AND $item['inMenu'] == 'admin')
                $res[$router->pathFor($name)] = $item['menuTitle'];

        return $res;
    }
}