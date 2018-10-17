<?php

namespace Polyloans\Filter\PersistenceLayer\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Polyloans\Filter\PersistenceLayer\Models\Filter;

class FilterRepository
{
    /**
     * @param string $filterName
     * @param string $filterKey
     * @param string $filterUrl
     * @param int    $userId
     * @param string $formData
     *
     * @return Filter
     */
    public function create(
        string $filterName,
        string $filterKey,
        string $filterUrl,
        int $userId,
        string $formData
    ): Filter {
        $filter = new Filter();

        $filter->name = $filterName;
        $filter->filter_key = $filterKey;
        $filter->filter_url = $filterUrl;
        $filter->user_id = $userId;
        $filter->form_data = $formData;

        $this->save($filter);

        return $filter;
    }

    /**
     * @param Filter $filter
     */
    public function save(Filter $filter): void
    {
        $filter->save();
    }

    /**
     * @param string $url
     *
     * @return Collection
     */
    public function getFiltersByUrl(string $url): Collection
    {
        return Filter::where('filter_url', $url)->get();
    }

    /**
     * @param int $id
     *
     * @throws \Exception
     */
    public function delete(int $id)
    {
        Filter::find($id)->delete();
    }
}
