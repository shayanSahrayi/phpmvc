<?php

namespace App\Core;

use ReflectionClass;
use ReflectionMethod;


class Route
{
    private static $routes = [];
    public function distpache()
    {

        $requestUri = str_replace(BASE_DOMAIN, '', $_SERVER['REQUEST_URI']);

        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), "/");
        $method = $_SERVER['REQUEST_METHOD'];
        if (isset(self::$routes[$method])) {

            foreach (self::$routes[$method] as $routeUri => $controllerAction) {
                $routeUri = trim(BASE_DOMAIN . $routeUri, "/");
                // تبدیل {id} به یک پارامتر اجباری
                $pattern = preg_replace('/\{(\w+)\}/', '(\w+)', $routeUri);
                // جایگذاری صحیح اسلش‌ها
                $pattern = str_replace('/', '\/', $pattern);
                // اجرای regex برای تطبیق مسیر ورودی با الگو
                if (preg_match("~^$pattern$~", $uri, $matches)) {
                    // حذف اولین عضو که همیشه مسیر کامل است
                    array_shift($matches);
                    // استخراج پارامترها
                    // if() check middleware =>{extraParams}
                    $params = self::extractParams($routeUri, $matches);
                    $request = new Request();
                    $middleware = $controllerAction['middleware'] ?? null;
                    $this->runMiddleware($middleware, function ($request) use ($controllerAction, $params) {
                        self::callAction($controllerAction, $params);
                    }, $request);
                    // (new $middleware())->handle($requst, function ($request) {});

                    return;
                }
            }
        }
        echo "404 Not Found";
    }
    private function runMiddleware($middlewares, $callback,  $index = 0, $request = [])
    {
        // ddd($middlewares[1]);
        if (!is_null($middlewares)) {
            if ($index < count($middlewares)) {
                $middleware = 'App\Middleware\\' . $middlewares[$index];
                (new $middleware())->handle($request, function ($request) use ($middlewares, $callback, $index) {

                    $this->runMiddleware($middlewares, $callback, $request, $index + 1);
                });
            }
        } else {
            $callback($request);
        }
    }
    private static function extractParams($routeUri, $matches)
    {
        preg_match_all('/\{(\w+)\}/', $routeUri, $paramNames);
        $params = [];
        foreach ($paramNames[1] as $index => $paramName) {
            $params[$paramName] = $matches[$index]; // پارامترها را از matches استخراج می‌کنیم
        }
        return $params;
    }

    // اجرای کنترلر
    private static function callAction($controllerAction, $params)
    {

        $class = $controllerAction['class'];

        if (class_exists($class)) {
            $method = $controllerAction['method'];
            $obj = new $class();
            if (method_exists($obj, $method)) {
                $request = new Request();
                $reflectionMethod = new ReflectionMethod($obj, $method);

                $parameters = $reflectionMethod->getParameters();

                $args = [];
                foreach ($parameters as $param) {

                    // اگر پارامتر از نوع Request باشد
                    if ($param->getType() && $param->getType()->getName() === 'App\Core\Request') {
                        $args[] = $request;
                    } else {
                        // پارامترهای روت را اضافه کنید
                        $args[] = array_shift($params);
                    }
                }

                call_user_func_array([$obj, $method], $args);
            }
        }
    }
    public function Get($url, array $action, $middleware = null)
    {
        self::$routes['GET'][$url] = ['class' => $action[0], 'method' => $action[1], 'middleware' => $middleware];
        return $this;
    }
    public function Post($url, array $action)
    {
        self::$routes['POST'][$url] = ['class' => $action[0], 'method' => $action[1], 'middleware' => ($action[2] ?? null)];;
        return $this;
    }
    public function Put($url, array $action)
    {
        self::$routes['PUT'][$url] = ['class' => $action[0], 'method' => $action[1], 'middleware' => ($action[2] ?? null)];;
        return $this;
    }
    public function Delete($url, array $action)
    {
        self::$routes['DELETE'][$url] = ['class' => $action[0], 'method' => $action[1], 'middleware' => ($action[2] ?? null)];;
        return $this;
    }
    public function middleware($middlewareClass)
    {
        ddd($this);
    }
    private function Action($class, $method, $request = 'null')
    {
        if (isset($class)) {
            if (class_exists($class)) {
                if (method_exists($class, $method)) {
                    $obj = new $class();
                    call_user_func([$obj, $method], []);
                } else {
                    ddd("not found method");
                }
            } else {
                ddd("not found Class");
            }
        } else {
            ddd("class is not set");
        }
    }

    public function notFound()
    {
        ddd("not found");
    }
}
