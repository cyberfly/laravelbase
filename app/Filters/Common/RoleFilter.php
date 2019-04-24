<?php

namespace App\Filters\Common;

use App\Filters\QueryFilters;
use Illuminate\Database\Eloquent\Builder;

class RoleFilter extends QueryFilters
{
    /**
     * Filter by title / code / description
     *
     * @param $search
     * @return Builder
     */
    public function search($search)
    {
        $search_type = request()->get('search_type');

        return $this->builder
            ->where(function ($query) use ($search, $search_type) {

                if (!empty($search_type)) {

                    if ($search_type === 'name') {

                        if (!empty($search)) {
                            $query->where($search_type, $search);
                        }
                    }
                    else {
                        $query->where($search_type, 'like', '%' . $search . '%');
                    }
                }
                else {
                    $query->orWhere('name', 'like', '%' . $search . '%')
                        ->orWhere('description',  'like', '%' . $search . '%');
                }
            });
    }

    /**
     * Filter by name
     *
     * @param  string $name
     * @return Builder
     */
    public function name($name)
    {
        return $this->builder->where('name', $name);
    }

    /**
     * Filter by description
     *
     * @param  string $description
     * @return Builder
     */
    public function description($description)
    {
        return $this->builder->where('description', 'like', '%' . $description . '%');
    }

    /**
     * Filter by latest.
     *
     * @param  string $order
     * @return Builder
     */
    public function latest($order = 'desc')
    {
        return $this->builder->orderBy('created_at', $order);
    }
}
