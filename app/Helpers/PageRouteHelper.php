<?php

namespace App\Helpers;

use App\Attributes\PageRouteAction;
use ReflectionClass;
use ReflectionMethod;

class PageRouteHelper
{
    public static function getControllers(): array
    {
        $controllers = [];
        $controllerFiles = glob(app_path('Http/Controllers/*.php'));

        foreach ($controllerFiles as $controller) {
            $controllerName = basename($controller, '.php');
            $controllerClass = "App\\Http\\Controllers\\{$controllerName}";
            $controllers[$controllerClass] = $controllerName;
        }

        return $controllers;
    }

    public static function getActions(string $controllerClass): array
    {
        if (!class_exists($controllerClass)) {
            return [];
        }

        $reflection = new ReflectionClass($controllerClass);
        $methods = [];

        foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if (
                $method->class === $controllerClass &&
                !$method->isConstructor() &&
                !$method->isStatic() &&
                !str_starts_with($method->name, '__')
            ) {
                $attributes = $method->getAttributes(PageRouteAction::class);
                if (!empty($attributes)) {
                    $methods[$method->name] = $method->name;
                }
            }
        }

        return $methods;
    }
}
