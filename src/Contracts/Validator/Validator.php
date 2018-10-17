<?php

namespace Polyloans\Filter\Contracts\Validator;

use Illuminate\Support\Collection;

interface Validator
{
    public function validate(array $parameters): void;

    public function errors(): Collection;

    public function isValid(): bool;
}
