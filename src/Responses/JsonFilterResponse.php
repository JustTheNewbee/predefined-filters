<?php

namespace Polyloans\Filter\Responses;

use Polyloans\Filter\Contracts\Response\Response;
use Polyloans\Filter\Services\FilterParametersConverterService;

class JsonFilterResponse implements Response
{
    /**
     * @var array
     */
    protected $filters;

    /**
     * JsonFilterResponse constructor.
     *
     * @param array $filters
     */
    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    /**
     * @return string
     */
    public function makeResponse(): string
    {
        $response[] = [
            'name' => 'Filters',
            'id' => '',
            'parameters' => [],
        ];

        foreach ($this->filters as $filter) {
            $filterFormData = json_decode($filter->getFormData());
            $response[] = [
                'name' => $filter->getFilterName(),
                'id' => $filter->getFilterId(),
                'parameters' => FilterParametersConverterService::prepareFilterParameters((array) $filterFormData),
            ];
        }

        return json_encode($response);
    }
}
