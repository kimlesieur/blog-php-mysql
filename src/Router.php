<?php 
namespace App;

class Router {
    /**
     * @var string
     */
    private $viewPath;
    
    /**
     * @var AltoRouter
     */
    private $router;

    public function __construct( string $viewPath)
    {
        $this->viewPath = $viewPath;
        $this->router = new \AltoRouter();
    }

    public function get(string $url, string $view, ?string $name = null): self 
    {
        $this->router->map('GET', $url, $view, $name);
        return $this;
    }

    public function post(string $url, string $view, ?string $name = null): self 
    {
        $this->router->map('POST', $url, $view, $name);
        return $this;
    }

    public function match(string $url, string $view, ?string $name = null): self 
    {
        $this->router->map('POST|GET', $url, $view, $name);
        return $this;
    }

    public function url(string $name, array $params = [])
    {
        return $this->router->generate($name, $params);
    }

    public function run(): self
    {
        $router=$this;
        $match= $this->router->match();
        $params = $match['params'];
        //dd($params);
        $view= $match['target'];
        ob_start();
        require $this->viewPath . $view . ".php";
        $content = ob_get_clean();
        require $this->viewPath.DIRECTORY_SEPARATOR."layouts/default.php";
        
        return $this;
    }

}


