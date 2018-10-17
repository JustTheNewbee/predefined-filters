<?php

namespace Polyloans\Filter\Commands\DeleteFilter;

use Polyloans\Filter\PersistenceLayer\Repositories\FilterRepository;

class Handler
{
    /**
     * @var FilterRepository
     */
    protected $filterRepository;

    /**
     * Handler constructor.
     *
     * @param FilterRepository $filterRepository
     */
    public function __construct(FilterRepository $filterRepository)
    {
        $this->filterRepository = $filterRepository;
    }

    /**
     * @param DeleteFilterCommand $event
     *
     * @throws \Exception
     */
    public function handle(DeleteFilterCommand $event)
    {
        $this->filterRepository->delete(
            $event->getFilterId()
        );
    }
}
