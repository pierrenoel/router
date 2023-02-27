<?php 

namespace Pierre\Router;

class Router
{    
    protected $routes = [];
    protected $uri;
    protected $method;

    public function __construct()
    {		
        $this->uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        $this->method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
    }

    public function get(string $uri, object $callable = null)
    {
        $this->add('GET',$uri,$callable);
    }

    public function post(string $uri,object $callable = null)
    {
        $this->add('POST',$uri,$callable);
    }

    public function delete(string $uri,object $callable = null) 
    {
        return $this->add('DELETE',$uri,$callable);
    }

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

    private function add(string $method, string $uri, object $callable = null) : array
    {
        return $this->routes[$uri] = [
            'uri' => $uri,
            'callable' => $callable,
            'method' => $method
        ];
    }

    protected function abort(Response $code = Response::NOT_FOUND) : void
    {
        http_response_code($code);
        echo 'Page not found';   
        die();
    }
}