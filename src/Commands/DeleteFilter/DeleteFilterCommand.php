<?php

namespace Polyloans\Filter\Commands\DeleteFilter;

class DeleteFilterCommand
{
    /**
     * @var int
     */
    protected $filterId;

    /**
     * DeleteFilterCommand constructor.
     *
     * @param int $filterId
     */
    public function __construct(int $filterId)
    {
        $this->filterId = $filterId;
    }

    /**
     * @return int
     */
    public function getFilterId(): int
    {
        return $this->filterId;
    }
}
