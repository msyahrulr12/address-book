<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Schema;

class GeneralRepository
{
    /**
     * @param array $query
     *
     * @return object
     */
    protected function search($qb, $search, $table)
    {
        $columns = \Illuminate\Support\Facades\Schema::getColumns($table);
        foreach ($columns as $column) {
            $name = $column['name'];
            $type = $column['type'];

            if ($name == 'id' || strpos($name, '_at') !== false || strpos($type, 'boolean') !== false) continue;

            if (strpos($type, 'int') !== false) {
                $value = '%'.strtolower($search).'%';
                $qb = $qb->orWhereRaw(sprintf('%s = ?', $name), '%'.$value.'%');
            } else {
                $value = '%'.strtolower($search).'%';
                $qb = $qb->orWhereRaw(sprintf('LOWER(%s) LIKE ?', $name), '%'.$value.'%');
            }
        }

        return $qb;
    }
}
