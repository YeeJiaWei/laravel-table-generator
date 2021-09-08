<?php


namespace YeeJiaWei\TableGenerator\Column;

class EnableColumn extends Column
{
    public $routeName;

    public function __construct(string $name, string $routeName)
    {
        parent::__construct($name);
        $this->routeName = $routeName;
    }
}