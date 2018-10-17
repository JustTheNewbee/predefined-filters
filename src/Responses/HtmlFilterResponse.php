<?php

namespace Polyloans\Filter\Responses;

use Polyloans\Filter\Contracts\Response\Response;
use Polyloans\Filter\Services\FilterParametersConverterService;

class HtmlFilterResponse implements Response
{
    /**
     * @var array
     */
    protected $filters;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * HtmlFilterResponse constructor.
     *
     * @param array  $filters
     * @param string $baseUrl
     */
    public function __construct(array $filters, string $baseUrl)
    {
        $this->filters = $filters;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return string
     */
    public function makeResponse(): string
    {
        $response[] = [
            'name' => 'Filters',
            'url' => $this->baseUrl,
            'id' => '',
        ];

        foreach ($this->filters as $filter) {
            $filterFormData = FilterParametersConverterService::prepareFilterParameters((array) json_decode($filter->getFormData()));
            $urlSearch = $this->makeUrlSearchFromFormData($filterFormData);

            $response[] = [
                'name' => $filter->getFilterName(),
                'url' => $this->baseUrl.'?'.$urlSearch.'#'.$filter->getFilterId(),
                'id' => $filter->getFilterId(),
            ];
        }

        return json_encode($response);
    }

    protected function makeUrlSearchFromFormData(array $formData): string
    {
        $httpSearchParameters = [];

        foreach ($this->extractSingleInputsFromFormData($formData) as $singleInput) {
            $httpSearchParameters[$singleInput['name']] = $singleInput['value'];
        }

        return implode('&', array_filter([
            http_build_query($httpSearchParameters),
            $this->buildMultipleSubquery($this->extractMultipleInputsFromFormData($formData)),
        ]));
    }

    protected function extractSingleInputsFromFormData(array $formData): array
    {
        return array_filter($formData, function ($formInput) {
            return !preg_match('/.*\[\]/', $formInput['name']);
        });
    }

    protected function extractMultipleInputsFromFormData(array $formData): array
    {
        return array_filter($formData, function ($formInput) {
            return preg_match('/.*\[\]/', $formInput['name']);
        });
    }

    protected function buildMultipleSubquery(array $multipleInputs)
    {
        $httpSearchSubquery = '';
        foreach ($multipleInputs as $input) {
            $httpSearchSubquery .= http_build_query([
                $input['name'] => $input['value'],
            ]).'&';
        }

        return preg_replace('/&$/', '', $httpSearchSubquery);
    }
}
