<?php

class AuthTest
{
    protected $ci;

    public function __construct($ci)
    {
        $this->ci = $ci;
    }

    /**
     * AuthTest middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface $response PSR7 response
     * @param  callable $next Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        global $_SESSION, $_SERVER;

        session_start();

        $cmd = $request->getQueryParam('auth');

        // is authorized?
        if (isset($_SESSION['user']) AND isset($_SESSION['REMOTE_ADDR']) AND $_SESSION['REMOTE_ADDR'] == $_SERVER['REMOTE_ADDR']) {
            // authorized.

            // is logout command received ?
            if ($cmd == 'logout') {
                $this->ci->get('logger')->info($_SESSION['user'].'退出了管理系统！');
                // log out and redirect to client area
                unset($_SESSION['user']);
                
                session_write_close();
                
                return $response
                    ->withStatus(301)
                    ->withHeader('Location', $this->ci['siteURI'] . '/');
            }

            // continue authorized operation
            return $next($request, $response);
        }

        // not authorized

        if (isset($_SESSION['user']))
            unset($_SESSION['user']);

        $out = [];

        // maybe authorization form is submitted ?
        if ($cmd == 'login' AND $request->isPost()) {
            $data = $request->getParsedBody();

            if (isset($data['name']) AND isset($data['pwd'])) {
                $name = trim($data['name']);
                if (isset($this->ci['users'][$name])) {
                    $pwd = trim($data['pwd']);
                    if ($this->ci['users'][$name] == $pwd) {

                        // success! Authorize this user
                        $_SESSION['user'] = $name;
                        $_SESSION['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];

                        // and redirect to typed url
                        $_SESSION['message'] = 'Hi, ' . $_SESSION['user'] . '!';
                        session_write_close();

                        $this->ci->get('logger')->info($_SESSION['user'].'登录了系统！');
                        $router = $this->ci->get('router');
                        $route = $request->getAttribute('route');
                        return $response
                            ->withStatus(301)
                            ->withHeader('Location', $this->ci['siteURI'] . $router->pathFor($route->getName()));

                    } else {
                        $out['message'] = 'Password incorrect!';
                    }
                } else {
                    $out['message'] = 'User does not exist!';
                }
            } else {
                $out['message'] = 'Data transfer error!';
            }
        }

        // show authorization screen

        session_write_close();
        return $response
            ->withStatus(200)
            ->withHeader('Content-Type', 'text/html')
            ->write($this->ci->get('twig')->render('admin/auth.html', $out));
    }
}