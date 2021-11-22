<?php

/**
 * @version 1.0
 * @author Orlyk Yurii <aigletter@gmail.com>
 */

namespace framework;

use framework\Components\ComponentFactoryAbstract;
use framework\Components\Router\Exceptions\RouteException;
use framework\Interfaces\CacheInterface;
use framework\Interfaces\ContainerInterface;
use framework\Interfaces\RunnableInterface;

/**
 * Class Application
 * Сервис локатор
 * @link https://docs.phpdoc.org/3.0/guide/references/phpdoc/tags/link.html#link
 * @package framework
 * @property CacheInterface $cache
 * @method callable route()
 */
class Application implements RunnableInterface, ContainerInterface, \Psr\Container\ContainerInterface
{
    /**
     * @var Application
     */
    protected static $instance;

    /*protected $router;

    protected $cache;*/

    protected $aliases = [];

    protected $bindings = [];

    /**
     * Массив компонентов (сервисов)
     * @var array
     */
    protected $components = [];

    /**
     * Возвращает инстанс своего класса - реализация паттерна Singleton
     * @return Application
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    protected function __construct()
    {
    }

    /**
     * @param array $config
     * @return void
     */
    public function configure($config)
    {
        if (isset($config['components'])) {
            foreach ($config['components'] as $name => $item) {
                $params = $item['params'] ?? [];
                if (isset($item['factory'])) {
                    $factoryName = $item['factory'];
                    $this->bindings[$name] = function () use ($factoryName, $params) {
                        $factory = new $factoryName($this, $params);
                        $instance = $factory->createInstance();
                        return $instance;
                    };
                } elseif (isset($item['class'])) {
                    $class = $item['class'];
                    $this->bindings[$name] = function () use ($class, $params) {
                        $instance = $this->make($class, $params);
                        return $instance;
                    };
                }
                if (isset($item['aliases'])) {
                    foreach ((array) $item['aliases'] as $alias) {
                        $this->aliases[$alias] = $name;
                    }
                }
            }
        }
    }

    /**
     * Запуск приложения
     * @throws \Exception
     */
    public function run()
    {
        try {
            $action = $this->get('router')->route();
            echo $this->callAction($action);
        } catch (RouteException $exception) {
            http_response_code();
            echo 'Not found';
        }
    }

    /**
     * Вызов метода контроллера
     * @param callable $action
     * @return mixed
     * @throws \ReflectionException
     */
    public function callAction(callable $action)
    {
        if (is_array($action)) {
            $reflectionClass = new \ReflectionClass($action[0]);
            $reflectionMethod = $reflectionClass->getMethod($action[1]);
            $arguments = [];
            foreach ($reflectionMethod->getParameters() as $parameter) {
                $name = $parameter->getName();
                if (isset($_GET[$name])) {
                    $type = (string) $parameter->getType();
                    settype($_GET[$name], $type);
                    $arguments[$name] = $_GET[$name];
                }
            }
            return $reflectionMethod->invokeArgs($action[0], $arguments);
        }

        $reflectionFunction = new \ReflectionFunction($action);
        return $reflectionFunction->invokeArgs([]);
    }

    public function make($className, $params = [])
    {
        $reflectionClass = new \ReflectionClass($className);
        $constructor = $reflectionClass->getConstructor();
        if ($constructor) {
            $arguments = $this->resolveDependencies($constructor, $params);
        }
        $instance = $reflectionClass->newInstanceArgs($arguments);

        return $instance;
    }

    public function resolveDependencies(\ReflectionFunctionAbstract $method, $params = [])
    {
        $arguments = [];
        foreach ($method->getParameters() as $parameter) {
            $name = $parameter->getName();
            $type = $parameter->getType();
            if ($type && !$type->isBuiltin()) {
                $arguments[$name] = $this->get((string) $type);
            } elseif (array_key_exists($name, $params)) {
                $arguments[$name] = $params[$name];
            }
        }
        return $arguments;
    }

    /**
     * @param $key
     * @return mixed
     * @throws \Exception
     * @since 2.1
     */
    public function get($key)
    {
        $key = $this->aliases[$key] ?? $key;

        if (array_key_exists($key, $this->components)) {
            return $this->components[$key];
        }

        if (array_key_exists($key, $this->bindings)) {
            $instance = call_user_func($this->bindings[$key]);
            $this->components[$key] = $instance;
            return $instance;
        }

        throw new \Exception('Component ' . $key . ' not found');
    }

    /*public function __get($name)
    {
        return $this->get($name);
    }*/

    public function set($key, $value)
    {
        // TODO: Implement set() method.
    }

    /*public function __set($name, $value)
    {
        $this->set($name, $value);
    }*/

    public function __call($name, $arguments)
    {
        if ($name === 'route') {
            return $this->get('router')->route();
        }

        throw new \Exception('Method not found');
    }

    /**
     * @return mixed
     * @deprecated
     * @see Application::get
     * @throws \Exception
     * @todo Удалить в версии 3
     */
    public function getCache()
    {
        return $this->get('cache');
    }

    public function has(string $id)
    {
        // TODO: Implement has() method.
    }
}