<?php

namespace Polyloans\Filter\Commands\CreateFilter;

class CreateFilterCommand
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $filterUrl;

    /**
     * @var string
     */
    protected $filterKey;

    /**
     * @var int
     */
    protected $userId;

    /**
     * @var string
     */
    protected $formData;

    /**
     * CreateFilterCommand constructor.
     *
     * @param string $name
     * @param string $filterUrl
     * @param string $filterKey
     * @param int    $userId
     * @param string $formData
     */
    public function __construct(
        string $name,
        string $filterUrl,
        string $filterKey,
        int $userId,
        string $formData
    ) {
        $this->name = $name;
        $this->filterUrl = $filterUrl;
        $this->filterKey = $filterKey;
        $this->userId = $userId;
        $this->formData = $formData;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getFilterUrl(): string
    {
        return $this->filterUrl;
    }

    /**
     * @return string
     */
    public function getFilterKey(): string
    {
        return $this->filterKey;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getFormData(): string
    {
        return $this->formData;
    }
}
