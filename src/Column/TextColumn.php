<?php


namespace YeeJiaWei\TableGenerator\Column;

class TextColumn extends Column
{
    public $sortable = false;

    public $searchable = false;

    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function sortable()
    {
        $this->sortable = true;

        return $this;
    }

    public function searchable()
    {
        $this->searchable = true;

        return $this;
    }
}