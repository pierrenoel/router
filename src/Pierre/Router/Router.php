<?php 

/**
 * @author      Pierre <pierrenoel@hotmail.be>
 * @copyright   Copyright (c), 2023 Pierre
 * @license     MIT public license
 */

namespace Pierre\Router;

class Router
{    
    /**
     * @var array $routes An array of routes.
     */
    protected array $routes = [];

    /**
     * @var string $uri The request URI.
     */
    protected string $uri;

    /**
     * @var string $uri The request URI.
     */
    protected string $method;

     /**
     * Initializes a new instance of the Router class.
     */
    public function __construct()
    {		
        $this->uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        $this->method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Adds a GET route.
     *
     * @param string $uri The URI of the route.
     * @param object $callable The callable function of the route.
     */
    public function get(string $uri, object $callable)
    {
        $this->add('GET',$uri,$callable);
    }

    /**
     * Adds a POST route.
     *
     * @param string $uri The URI of the route.
     * @param object $callable The callable function of the route.
     */
    public function post(string $uri,object $callable)
    {
        $this->add('POST',$uri,$callable);
    }

    /**
     * Adds a DELETE route.
     *
     * @param string $uri The URI of the route.
     * @param object $callable The callable function of the route.
     */
    public function delete(string $uri,object $callable) 
    {
        return $this->add('DELETE',$uri,$callable);
    }

    /**
     * Runs the router.
    */
    public function run() : void
    {
        foreach ($this->routes as $route) {
            
            $route['uri'] = preg_replace('/(:\w+)/', '(\d+)', $route['uri']);
            
            $route['uri'] = '/^' . str_replace('/', '\/', $route['uri']) . '$/';
            
            if (preg_match($route['uri'], $this->uri, $matches) && $this->method === $route['method']) {
                echo $route['callable']($matches[1]);
                return;
            }
        }

        $this->abort();
    }

    /**
     * Adds a new route.
     *
     * @param string $method The HTTP method of the route.
     * @param string $uri The URI of the route.
     * @param object|null $callable The callable function of the route.
     *
     * @return array The newly added route.
     */
    private function add(string $method, string $uri, object $callable) : array
    {
        return $this->routes[$uri] = [
            'uri' => $uri,
            'callable' => $callable,
            'method' => $method
        ];
    }

    /**
     * Aborts the request.
     *
     * @param int $code The HTTP status code to return.
     */
    protected function abort($code = Response::NOT_FOUND)
    {
        http_response_code($code);
        echo 'Page not found';
        die();
    }

}