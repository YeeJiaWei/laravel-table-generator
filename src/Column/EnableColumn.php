<?php


namespace YeeJiaWei\TableGenerator\Column;

use YeeJiaWei\TableGenerator\Traits\SortableColumn;

class EnableColumn extends Column
{
    use SortableColumn;

    public $routeName;

    public function __construct(string $name, string $routeName)
    {
        parent::__construct($name);
        $this->routeName = $routeName;
    }


}