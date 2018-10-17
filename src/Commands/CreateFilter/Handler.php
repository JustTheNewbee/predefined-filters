<?php

namespace Polyloans\Filter\Commands\CreateFilter;

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
     * @param CreateFilterCommand $event
     */
    public function handle(CreateFilterCommand $event): void
    {
        $this->filterRepository->create(
            $event->getName(),
            $event->getFilterKey(),
            $event->getFilterUrl(),
            $event->getUserId(),
            $event->getFormData()
        );
    }
}
