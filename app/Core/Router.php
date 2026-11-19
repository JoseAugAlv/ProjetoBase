<?php
// app/Core/Router.php
// Registro e despacho de rotas.
//   $router->get('/produtos', 'ProdutoController@index', [Perfil::MASTER, Perfil::ADMIN]);
//   $router->post('/produtos/salvar', 'ProdutoController@salvar', [1, 2]);
//   $router->crud('produtos', 'ProdutoController', [1, 2]);   // 6 rotas de CRUD
// Roles vazio = rota pública. Todo POST é validado contra CSRF automaticamente.

class Router
{
    private $routes = ['GET' => [], 'POST' => []];

    public function get(string $uri, string $action, array $roles = []): void
    {
        $this->add('GET', $uri, $action, $roles);
    }

    public function post(string $uri, string $action, array $roles = []): void
    {
        $this->add('POST', $uri, $action, $roles);
    }

    /**
     * Registra as rotas padrão de um CRUD (usado com controllers que estendem CrudController).
     */
    public function crud(string $prefixo, string $controller, array $roles = [1, 2]): void
    {
        $p = '/' . trim($prefixo, '/');
        $this->get($p, "{$controller}@index", $roles);
        $this->get("{$p}/criar", "{$controller}@criar", $roles);
        $this->post("{$p}/salvar", "{$controller}@salvar", $roles);
        $this->get("{$p}/editar", "{$controller}@editar", $roles);
        $this->post("{$p}/atualizar", "{$controller}@atualizar", $roles);
        $this->post("{$p}/excluir", "{$controller}@excluir", $roles);
    }

    private function add(string $method, string $uri, string $action, array $roles): void
    {
        $uri = '/' . trim($uri, '/');
        $this->routes[$method][$uri] = ['action' => $action, 'roles' => array_map('intval', $roles)];
    }

    public function dispatch(string $requestUri): void
    {
        $path = rawurldecode((string) parse_url($requestUri, PHP_URL_PATH));

        // Remove o caminho base (ex: /ProjetoBase) respeitando o limite de pasta
        $basePath = App::getBasePath();
        if ($basePath !== '' && ($path === $basePath || strpos($path, $basePath . '/') === 0)) {
            $path = substr($path, strlen($basePath));
        }
        $path = '/' . trim($path, '/');

        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        if ($method === 'HEAD') {
            $method = 'GET';
        }

        [$route, $params] = $this->match($method, $path);

        if (!$route) {
            View::erro(404);
        }

        // CSRF em todo POST
        if ($method === 'POST') {
            CsrfMiddleware::validate();
        }

        // Permissões
        if (!empty($route['roles'])) {
            if (!Auth::check()) {
                if (!self::isAjax()) {
                    $_SESSION['url_pretendida'] = $path;
                    flash('aviso', 'Faça login para continuar.');
                }
                redirect('/login');
            }
            if (!Auth::hasRole($route['roles'])) {
                View::erro(403);
            }
        }

        [$controller, $metodo] = explode('@', $route['action']) + [null, null];

        if (!$controller || !$metodo || !class_exists($controller)) {
            throw new RuntimeException("Controller não encontrado para a rota {$path}: {$route['action']}");
        }

        $instancia = new $controller();
        if (!is_callable([$instancia, $metodo])) {
            throw new RuntimeException("Método {$controller}::{$metodo} não existe ou não é público.");
        }

        $instancia->$metodo(...$params);
    }

    private function match(string $method, string $path): array
    {
        if (isset($this->routes[$method][$path])) {
            return [$this->routes[$method][$path], []];
        }

        // Rotas com parâmetros: /produtos/{id}
        foreach ($this->routes[$method] ?? [] as $routePath => $routeData) {
            if (strpos($routePath, '{') === false) {
                continue;
            }
            $pattern = '#^' . preg_replace('#\{[a-zA-Z0-9_]+\}#', '([a-zA-Z0-9\-_]+)', $routePath) . '$#';
            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches);
                return [$routeData, $matches];
            }
        }

        return [null, []];
    }

    /** Lista de rotas registradas (usado por `php bin/console rotas`). */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    public static function isAjax(): bool
    {
        return ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest'
            || strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false;
    }
}
