<?php


namespace YeeJiaWei\TableGenerator;

use Illuminate\Support\Str;

class TableGenerator
{
    private $items;

    private $columns;

    private $table_name = 'Table';

    private $enable = false;
    private $enable_route_name;
    private $creatable = false;
    private $create_route_name;
    private $viewable = false;
    private $view_route_name;
    private $editable = false;
    private $edit_route_name;
    private $deletable = false;
    private $delete_route_name;

    public function __construct($items)
    {
        $this->items = $items;
        $this->columns = collect();

        return $this;
    }

    public static function create($items)
    {
        return new self($items);
    }

    public function setTableName(string $name): TableGenerator
    {
        $this->table_name = $name;
        return $this;
    }

    public function addColumn(
        string $columnName, string $type = 'text',
        string $classes = null, string $columnHeader = null): TableGenerator
    {
        $column = collect([
            'header' => $columnHeader ? $columnHeader : Str::of($columnName)->replace('_', ' '),
            'name' => $columnName,
            'class' => $classes,
            'type' => $type
        ]);

        $this->columns = $this->columns->push($column);

        return $this;
    }

    public function addCreatedAtColumns(string $format = null, string $classes = null, string $columnHeader = null): TableGenerator
    {
        $this->columns = $this->columns->push(collect([
            'header' => $columnHeader ? $columnHeader : 'created at',
            'name' => 'created_at',
            'format' => $format ? $format : 'd M Y h:m A',
            'class' => $classes
        ]));

        return $this;
    }

    public function addUpdatedAtColumns(string $format = null, string $classes = null, string $columnHeader = null): TableGenerator
    {

        $this->columns = $this->columns->push(collect([
            'header' => $columnHeader ? $columnHeader : 'updated at',
            'name' => 'updated_at',
            'format' => $format ? $format : 'd M Y h:m A',
            'class' => $classes
        ]));

        return $this;
    }

    public function setEnable(string $routeName): TableGenerator
    {
        $this->enable_route_name = $routeName;
        $this->enable = true;

        return $this;
    }

    public function setCreatable(string $routeName): TableGenerator
    {
        $this->create_route_name = $routeName;
        $this->creatable = true;

        return $this;
    }

    public function setViewable(string $routeName): TableGenerator
    {
        $this->view_route_name = $routeName;
        $this->viewable = true;

        return $this;
    }

    public function setEditable(string $routeName): TableGenerator
    {
        $this->edit_route_name = $routeName;
        $this->editable = true;

        return $this;
    }

    public function setDeletable(string $routeName): TableGenerator
    {
        $this->delete_route_name = $routeName;
        $this->deletable = true;

        return $this;
    }

    public function render()
    {
        return view('table-generator::table')
            ->with('table_name', $this->table_name)
            ->with('items', $this->items)
            ->with('columns', $this->columns)
            ->with('enable', $this->enable)
            ->with('enable_route_name', $this->enable_route_name)
            ->with('creatable', $this->creatable)
            ->with('create_route_name', $this->create_route_name)
            ->with('viewable', $this->viewable)
            ->with('view_route_name', $this->view_route_name)
            ->with('editable', $this->editable)
            ->with('edit_route_name', $this->edit_route_name)
            ->with('deletable', $this->deletable)
            ->with('delete_route_name', $this->delete_route_name);
    }
}
