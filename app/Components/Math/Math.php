<?php


namespace app\Components\Math;


use framework\Interfaces\CacheInterface;

class Math
{
    protected $cache;

    protected $test;

    public function __construct(string $test, CacheInterface $cache, int $count = 0)
    {
        $this->cache = $cache;
        $this->test = $test;
        $this->count = $count;
    }

    public function sum($a, $b)
    {
        return $a + $b;
    }
}