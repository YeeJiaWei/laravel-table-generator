<?php


namespace YeeJiaWei\TableGenerator\Traits;

use YeeJiaWei\TableGenerator\Column\Column;
use YeeJiaWei\TableGenerator\Column\DateTimeColumn;
use YeeJiaWei\TableGenerator\Column\EnableColumn;

trait HasColumns
{
    protected $columns;

    public function __construct()
    {
        $this->columns = collect();
    }

    public function addColumn(Column $column)
    {
        $this->columns = $this->columns->push($column);

        return $this;
    }

    public function addCreatedAtColumn()
    {
        $this->columns = $this->columns->push((new DateTimeColumn('created_at'))->sortable());

        return $this;
    }

    public function addUpdatedAtColumn()
    {
        $this->columns = $this->columns->push((new DateTimeColumn('updated_at'))->sortable());

        return $this;
    }

    public function addEnableColumn(string $routeName)
    {
        $this->columns = $this->columns->push((new EnableColumn('enable', $routeName))->sortable());

        return $this;
    }
}