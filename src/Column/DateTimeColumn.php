<?php


namespace YeeJiaWei\TableGenerator\Column;

use YeeJiaWei\TableGenerator\Traits\SortableColumn;

class DateTimeColumn extends Column
{
    use SortableColumn;

    public $format = 'd M Y h:m A';

    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function format(string $format)
    {
        $this->format = $format;

        return $this;
    }
}