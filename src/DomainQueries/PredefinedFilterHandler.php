<?php

namespace Polyloans\Filter\DomainQueries;

use Polyloans\Filter\PersistenceLayer\Repositories\FilterRepository;

class PredefinedFilterHandler
{
    /**
     * @var FilterRepository
     */
    protected $filterRepository;

    /**
     * FilterHandler constructor.
     *
     * @param FilterRepository $filterRepository
     */
    public function __construct(FilterRepository $filterRepository)
    {
        $this->filterRepository = $filterRepository;
    }

    /**
     * @param string $filterUrl
     *
     * @return array
     */
    public function getFilters(string $filterUrl): array
    {
        return array_map(function ($n) {
            return new PredefinedFilterResult($n);
        }, $this->filterRepository->getFiltersByUrl($filterUrl)->toArray());
    }
}
