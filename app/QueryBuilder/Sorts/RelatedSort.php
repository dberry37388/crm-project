<?php

namespace App\QueryBuilder\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class RelatedSort implements Sort
{

    public function __invoke(Builder $query, bool $descending, string $property)
    {
        [$relationName, $columnName] = explode(".", $property);

        $relation = $query->getRelation($relationName);

        $subQuery = $relation
            ->getQuery()
            ->select($columnName)
            ->whereColumn($relation->getQualifiedForeignKeyName(), $relation->getQualifiedOwnerKeyName());

        $query->orderBy($subQuery, $descending ? "desc" : "asc");
    }
}
