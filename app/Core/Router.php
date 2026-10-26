<?php
declare(strict_types=1);
namespace MyHR\Core;

final class Router
{
    private array $routes = ['GET' => [], 'POST' => []];
    private array $aliases = [];

    public function alias(string $name, callable $fn): void { $this->aliases[$name] = $fn; }
    public function get(string $path, array $h, array $mw = []): void  { $this->add('GET',  $path, $h, $mw); }
    public function post(string $path, array $h, array $mw = []): void { $this->add('POST', $path, $h, $mw); }

    private function add(string $method, string $path, array $h, array $mw): void
    {
        $regex = preg_replace('#\{([a-zA-Z_]+)\}#', '(?P<$1>[^/]+)', $path);
        $this->routes[$method][] = [
            'pattern'    => $path,
            'regex'      => '#^' . $regex . '$#',
            'handler'    => $h,
            'middleware' => $mw,
        ];
    }

    public function dispatch(Request $req): void
    {
        foreach ($this->routes[$req->method] ?? [] as $route) {
            if (preg_match($route['regex'], $req->path, $m)) {
                $params = array_filter($m, 'is_string', ARRAY_FILTER_USE_KEY);
                $this->runMiddleware($route['middleware'], $req, $params);
                [$class, $method] = $route['handler'];
                $c = new $class();
                echo $c->{$method}($req, $params) ?? '';
                return;
            }
        }
        http_response_code(404);
        echo View::render('errors/404', ['path' => $req->path], null);
    }

    private function runMiddleware(array $chain, Request $req, array $params): void
    {
        foreach ($chain as $entry) {
            [$name, $arg] = array_pad(explode(':', $entry, 2), 2, null);
            if (!isset($this->aliases[$name])) throw new \RuntimeException("Unknown middleware: $name");
            ($this->aliases[$name])($req, $arg);
        }
    }
}