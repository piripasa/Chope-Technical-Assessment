<?php


namespace App\Service\Pagination;


use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class Pagination
{
    private $items;

    /**
     * Pagination constructor.
     * @param $items
     */
    public function __construct($items)
    {
        $this->items = $items;
    }

    /**
     * @param int $perPage
     * @param int $page
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 5, int $page = 1, array $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $this->items instanceof Collection ? $this->items : Collection::make($this->items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
