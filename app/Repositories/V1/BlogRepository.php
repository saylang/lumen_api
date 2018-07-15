<?php

namespace App\Repositories\V1;

use Prettus\Repository\Eloquent\BaseRepository;

class BlogRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model() {
        return 'App\Models\Blog';
    }

    /**
     * Get categories list
     */
    public function getList() {
        $this->applyConditions([
            'status' => 1
        ]);
        $this->orderBy('sort_order', 'ASC');
        $categories = $this->all();
        return $categories;
    }
}