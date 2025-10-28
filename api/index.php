<?php

try {
    spl_autoload_register(function(string $className){
        require_once __DIR__.'/../'.str_replace('\\','/',$className.'.php');
    });

    $route = $_GET['route'] ?? '';
    $routes = require __DIR__.'/../Src/Config/routes_api.php';

    $isRouteFound = false;
    foreach($routes as $pattern => $controllerAndAction){
        preg_match($pattern, $route, $matches);
        if(!empty($matches)) {
            $isRouteFound = true;
            break;
        }
    }

    if (!$isRouteFound) {
        throw new \Src\Exceptions\NotFoundException("no result on '".$_GET['route']."' search");
    }

    $controllerName = $controllerAndAction[0];
    if (array_key_exists("POST", $controllerAndAction) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $actionName = $controllerAndAction["POST"];
    }
    elseif (array_key_exists("GET", $controllerAndAction) && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $actionName = $controllerAndAction["GET"];
    }
    elseif (array_key_exists("PUT", $controllerAndAction) && $_SERVER['REQUEST_METHOD'] === 'PUT') {
        $actionName = $controllerAndAction["PUT"];
    }
    elseif (array_key_exists("PATCH", $controllerAndAction) && $_SERVER['REQUEST_METHOD'] === 'PATCH') {
        $actionName = $controllerAndAction["PATCH"];
    }
    else {
        $actionName = $controllerAndAction[1];
    }

    unset($matches[0]);
    $controller = new $controllerName();
    $controller->$actionName(...$matches);
} catch (\Src\Exceptions\DbException $e) {
    $view = new \Src\Views\View('default');
    $view->displayJSON(['error'=>$e->getMessage()],500);
}catch (\Src\Exceptions\NotFoundException $e) {
    $view = new \Src\Views\View('default');
    $view->displayJSON(['error'=>$e->getMessage()],404);
} catch (\Src\Exceptions\UnauthorizedException $e) {
    $view = new \Src\Views\View('default');
    $view->displayJSON(['error'=>$e->getMessage()],401);
} 