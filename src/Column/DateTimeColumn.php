<?php


namespace YeeJiaWei\TableGenerator\Column;

use Illuminate\Support\Str;

class DateTimeColumn extends Column
{
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