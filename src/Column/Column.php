<?php


namespace YeeJiaWei\TableGenerator\Column;

use Illuminate\Support\Str;

class Column
{
    public $name;

    public $header;

    public $class;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->header = Str::of($name)->replace('_', ' ');
    }

    public function header(string $header)
    {
        $this->header = $header;

        return $this;
    }

    public function class(string $classes)
    {
        $this->class = $classes;

        return $this;
    }
}