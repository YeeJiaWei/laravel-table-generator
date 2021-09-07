<?php


namespace YeeJiaWei\TableGenerator;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;

class TableGenerator
{
    private $layout = 'layouts.app';

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

    public function setLayout(string $layout): TableGenerator
    {
        $this->layout = $layout;

        return $this;
    }

    public function setTableName(string $name): TableGenerator
    {
        $this->table_name = $name;
        return $this;
    }

    public function addColumn(
        string $columnName, string $classes = null, string $columnHeader = null): TableGenerator
    {
        $column = collect([
            'type' => 'text',
            'header' => $columnHeader ? $columnHeader : Str::of($columnName)->replace('_', ' '),
            'name' => $columnName,
            'class' => $classes,
        ]);

        $this->columns = $this->columns->push($column);

        return $this;
    }

    public function addImageColumn(string $columnName, string $path = null, string $header = null)
    {
        $this->columns = $this->columns->push(collect([
            'type' => 'image',
            'header' => $header ? $header : 'Image',
            'name' => $columnName,
            'path' => $path ? $path : asset('storage'),
            'no_image' => asset('image/image-not-available.png'),
            'class' => null,
        ]));

        return $this;
    }

    public function addCreatedAtColumns(string $format = null, string $columnHeader = 'created at'): TableGenerator
    {
        $this->columns = $this->columns->push(collect([
            'header' => $columnHeader,
            'name' => 'created_at',
            'format' => $format ? $format : 'd M Y h:m A',
        ]));

        return $this;
    }

    public function addUpdatedAtColumns(string $format = null, string $columnHeader = 'updated at'): TableGenerator
    {
        $this->columns = $this->columns->push(collect([
            'header' => $columnHeader,
            'name' => 'updated_at',
            'format' => $format ? $format : 'd M Y h:m A',
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
        $this->layout = View::make($this->layout);
        $this->layout->header = View::make('table-generator::header')
            ->with('table_name', $this->table_name)
            ->with('creatable', $this->creatable)
            ->with('create_route_name', $this->create_route_name);

        $this->layout->slot = View::make('table-generator::table')
            ->with('items', $this->items)
            ->with('columns', $this->columns)
            ->with('enable', $this->enable)
            ->with('enable_route_name', $this->enable_route_name)
            ->with('viewable', $this->viewable)
            ->with('view_route_name', $this->view_route_name)
            ->with('editable', $this->editable)
            ->with('edit_route_name', $this->edit_route_name)
            ->with('deletable', $this->deletable)
            ->with('delete_route_name', $this->delete_route_name);

        return $this->layout;
    }
}
