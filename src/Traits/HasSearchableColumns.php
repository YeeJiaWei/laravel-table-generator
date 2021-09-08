<?php


namespace YeeJiaWei\TableGenerator\Traits;


trait HasSearchableColumns
{
    public function scopeSearch($query, array $search)
    {
        foreach ($search as $column => $value) {
            if (str_contains($column, '-')) {
                $c = explode('-', $column);

                $query = $query->whereHas($c[0], function ($query) use ($value, $c) {
                    $query->where($c[1], 'like', '%' . $value . '%');
                });

            } else {
                if ($column != 'page' && $value != null) {
                    if ($column == 'enable') {
                        $query = $query->where($column, (bool)$value);
                    } else {
                        $query = $query->where($column, 'like', '%' . $value . '%');
                    }
                }
            }
        }

        return $query;
    }
}