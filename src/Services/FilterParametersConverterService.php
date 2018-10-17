<?php

namespace Polyloans\Filter\Services;

use Carbon\Carbon;

class FilterParametersConverterService
{
    /**
     * @param array  $parameters
     * @param string $dateFormat
     *
     * @return array
     */
    public static function prepareFilterParameters(array $parameters, string $dateFormat = 'Y-m-d'): array
    {
        $convertedParameters = [];
        foreach ($parameters as $parameter) {
            if ('dynamic' === $parameter->type) {
                $convertedParameters[] = [
                    'name' => $parameter->name,
                    'value' => ('' === $parameter->value) ? $parameter->value : Carbon::parse($parameter->value)->format($dateFormat),
                ];
            } else {
                $convertedParameters[] = [
                    'name' => $parameter->name,
                    'value' => $parameter->value,
                ];
            }
        }

        return $convertedParameters;
    }
}
