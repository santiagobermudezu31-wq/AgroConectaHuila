<?php
declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $p, array $h, array $m = []): void    { $this->add('GET', $p, $h, $m); }
    public function post(string $p, array $h, array $m = []): void   { $this->add('POST', $p, $h, $m); }
    public function put(string $p, array $h, array $m = []): void    { $this->add('PUT', $p, $h, $m); }
    public function patch(string $p, array $h, array $m = []): void  { $this->add('PATCH', $p, $h, $m); }
    public function delete(string $p, array $h, array $m = []): void { $this->add('DELETE', $p, $h, $m); }

    private function add(string $m, string $p, array $h, array $mw): void
    {
        $this->routes[] = compact('m', 'p', 'h', 'mw');
    }

    public function dispatch(string $method, string $uri): void
    {
        $base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
        if ($base !== '' && str_starts_with($uri, $base)) {
            $uri = substr($uri, strlen($base));
        }
        $uri = '/' . trim($uri, '/');

        foreach ($this->routes as $r) {
            if ($r['m'] !== $method) continue;
            $pat = '#^' . preg_replace('#\{[a-zA-Z_]+\}#', '([^/]+)', $r['p']) . '$#';
            if (preg_match($pat, $uri, $matches)) {
                array_shift($matches);
                foreach ($r['mw'] as $mw) {
                    $mwInstance = is_string($mw) ? new $mw() : $mw;
                    $ok = $mwInstance->handle();
                    if ($ok === false) return;
                }
                [$class, $action] = $r['h'];
                (new $class())->{$action}(...$matches);
                return;
            }
        }

        http_response_code(404);
        header('Content-Type: text/html; charset=utf-8');
        echo '<h1>404 — Página no encontrada</h1><a href="/AgroConectaHuila/">Volver al inicio</a>';
    }
}