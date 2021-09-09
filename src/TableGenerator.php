<?php


namespace YeeJiaWei\TableGenerator;

use Illuminate\Support\Facades\View;
use YeeJiaWei\TableGenerator\Column\TextColumn;
use YeeJiaWei\TableGenerator\Traits\HasActions;
use YeeJiaWei\TableGenerator\Traits\HasColumns;

class TableGenerator
{
    use HasColumns {
        HasColumns::__construct as private __hasColumnConstruct;
    }

    use HasActions;

    private $layout = 'layouts.app';

    private $builder;

    private $pagination;

    private $table_name = 'Table';

    public function __construct($builder)
    {
        $this->__hasColumnConstruct();
        $this->builder = $builder;
        $this->query = request()->query();

        return $this;
    }

    public static function create($builder)
    {
        if ($builder instanceof \Illuminate\Database\Query\Builder
            || $builder instanceof \Illuminate\Database\Eloquent\Builder)
            return new self($builder);

        throw new \Exception("Must be 'Query\Builder' or 'Eloquent\Builder'");
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

    public function pagination()
    {
        $pagination = [];
        for ($i = 1; $i <= 5; $i++) {
            $pagination[$i * 20] = http_build_query(
                array_merge(request()->query(), ['perPage' => $i * 20])
            );
        }

        return $pagination;
    }

    public function render()
    {
        $hasSearchableColumn = !!$this->columns->first(function ($value) {
            if ($value instanceof TextColumn)
                return $value->searchable;
            return false;
        });

        if ($hasSearchableColumn) {
            foreach (request()->query() as $column => $value) {
                if ($column == 'page' || $column == 'perPage' || $column == 'order' || $column == 'orderBy')
                    continue;

                if (str_contains($column, '-')) {
                    $c = explode('-', $column);

                    $this->builder = $this->builder->whereHas($c[0], function ($query) use ($value, $c) {
                        $query->where($c[1], 'like', '%' . $value . '%');
                    });

                } elseif ($value != null) {
                    if ($column == 'enable') {
                        $this->builder = $this->builder->where($column, (bool)$value);
                    } else {
                        $this->builder = $this->builder->where($column, 'like', '%' . $value . '%');
                    }
                }
            }
        }

        $this->layout = View::make($this->layout);
        $this->layout->header = View::make('table-generator::header')
            ->with('table_name', $this->table_name)
            ->with('creatable', $this->creatable)
            ->with('create_route_name', $this->create_route_name);

        $items = $this->builder
            ->orderBy(
                request()->query('orderBy') ?: 'created_at',
                request()->query('order') ?: 'desc'
            )
            ->paginate(request()->query('perPage') ?: '20');

        $this->layout->slot = View::make('table-generator::table')
            ->with('items', $items)
            ->with('hasSearchableColumn', $hasSearchableColumn)
            ->with('pagination', $this->pagination())
            ->with('columns', $this->columns)
            ->with('viewable', $this->viewable)
            ->with('view_route_name', $this->view_route_name)
            ->with('editable', $this->editable)
            ->with('edit_route_name', $this->edit_route_name)
            ->with('deletable', $this->deletable)
            ->with('delete_route_name', $this->delete_route_name);

        return $this->layout;
    }
}
