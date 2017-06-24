<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class MainController
{
    protected $ci;

    public function __construct($ci)
    {
        $this->ci = $ci;
    }

    public function indexAction($request, $response, $args)
    {
        $entity = new Entity($this->ci['db']);
        $out = $entity->getIndex();

        if (!is_array($out))
            return self::e404Action($this->ci, $request, $response);

        $out['system'] = $entity->getIndex();
        $out['slides'] = $entity->getSlides();
        $out['serves'] = $entity->getServes();
        $out['cases'] = $entity->getCases();
        $out['news'] = $entity->getNews();
        $out['menu_selected'] = '/';

        return $this->ci['response']
            ->withHeader('Content-Type', 'text/html')
            ->write($this->ci->get('twig')->render('index.html', $out));
    }

    public function aboutsAction($request, $response, $args)
    {
        $entity = new Entity($this->ci['db']);
        $out = $entity->getIndex();

        if (!is_array($out))
            return self::e404Action($this->ci, $request, $response);

        $out['system'] = $entity->getIndex();
        $out['menu_selected'] = '/abouts/';

        return $this->ci['response']
            ->withHeader('Content-Type', 'text/html')
            ->write($this->ci->get('twig')->render('abouts.html', $out));
    }

    public function categoryAction($request, $response, $args)
    {
        $entity = new Entity($this->ci['db']);
        if (!isset($args['page']))
            $args['page'] = 0;

        $out = $entity->getCategory($args['id'], $args['page']);
        if (!is_array($out))
            return self::e404Action($this->ci, $request, $response);

        $out['system'] = $entity->getIndex();
        $out['menu'] = $entity->getMenu();
        $out['menu_selected'] = '/' . $args['id'] . '/';
        
        if($args['id'] === 'solutions'){
            $out['solutions1'] = $entity->getSolutions(1);
            $out['solutions2'] = $entity->getSolutions(2);
            $out['solutions3'] = $entity->getSolutions(3);
        }else if($args['id'] === 'products'){
            $out['products'] = $entity->getProducts();
        }else if($args['id'] === 'cases'){
            $out['cases'] = $entity->getCases();
        }else if($args['id'] === 'services'){
            $out['services'] = $entity->getServices();
        }else if($args['id'] === 'news'){
            $out['news'] = $entity->getNews();
        }else if($args['id'] === 'recruits'){
            $out['recruits'] = $entity->getRecruits();
        }
        return $this->ci['response']
            ->withHeader('Content-Type', 'text/html')
            ->write($this->ci->get('twig')->render($args['id'].'.html', $out));
    }

    public function articleAction($request, $response, $args)
    {
        $entity = new Entity($this->ci['db']);
        $out = $entity->getArticle($args['id']);

        if (!is_array($out))
            return self::e404Action($this->ci, $request, $response);

        $out['system'] = $entity->getIndex();
        $out['menu'] = $entity->getMenu();
        $out['menu_selected'] = '/' . $args['id'] . '.html';

        $html = 'article.html';
        if($args['module']=='solutions'){
            $html = 'solutions-inform.html';
        }else if($args['module']=='cases'){
            $html = 'cases-inform.html';
        }else if($args['module']=='news'){
            $html = 'news-inform.html';
        }

        return $this->ci['response']
            ->withHeader('Content-Type', 'text/html')
            ->write($this->ci->get('twig')->render($html, $out));
    }

}