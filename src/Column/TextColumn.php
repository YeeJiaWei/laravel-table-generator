<?php


namespace YeeJiaWei\TableGenerator\Column;

use YeeJiaWei\TableGenerator\Traits\SortableColumn;

class TextColumn extends Column
{
    use SortableColumn;

    public $searchable = false;

    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function searchable()
    {
        $this->searchable = true;

        return $this;
    }
}