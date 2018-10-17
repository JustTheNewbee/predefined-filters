<?php

namespace Polyloans\Filter\DomainQueries;

class PredefinedFilterResult
{
    /**
     * @var array
     */
    protected $rawData = [];

    /**
     * PredefinedFilterResult constructor.
     *
     * @param array $rawData
     */
    public function __construct(array $rawData)
    {
        $this->rawData = $rawData;
    }

    /**
     * @return int
     */
    public function getFilterId(): int
    {
        return $this->rawData['id'];
    }

    /**
     * @return string
     */
    public function getFilterName(): string
    {
        return $this->rawData['name'];
    }

    /**
     * @return mixed
     */
    public function getFilterUrl()
    {
        return $this->rawData['filter_url'];
    }

    /**
     * @return string
     */
    public function getFilterKey(): string
    {
        return $this->rawData['filter_key'];
    }

    /**
     * @return string
     */
    public function getFormData(): string
    {
        return $this->rawData['form_data'];
    }
}
