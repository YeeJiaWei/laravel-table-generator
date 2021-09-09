<?php


namespace YeeJiaWei\TableGenerator\Traits;


trait SortableColumn
{
    public $sortable;

    public function sortable()
    {
        $this->sortable = true;

        $newQuery = [
            'order' => request()->query('order') != '' && request()->query('order') != 'desc'
                ? 'desc'
                : 'asc',
            'orderBy' => $this->name
        ];

        $this->query = http_build_query(array_merge(request()->query(), $newQuery));

        return $this;
    }
}