<?php

namespace Polyloans\Filter\Validators;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Polyloans\Filter\Contracts\Validator\Validator;

class FilterValidator implements Validator
{
    /**
     * @var array
     */
    protected $errors;

    /**
     * FilterValidator constructor.
     */
    public function __construct()
    {
        $this->errors = collect();
    }

    /**
     * @param array $parameters
     */
    public function validate(array $parameters): void
    {
        foreach ($parameters as $parameter) {
            if ('dynamic' === $parameter->type) {
                try {
                    new Carbon($parameter->value);
                } catch (\Exception $exception) {
                    $this->errors->push([
                        'name' => $parameter->name,
                        'message' => 'Date format is incorrect',
                    ]);
                }
            }
        }
    }

    /**
     * @return Collection
     */
    public function errors(): Collection
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->errors->isEmpty();
    }
}
