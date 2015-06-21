<?php

namespace AppBundle\Service;


/**
 * QueryInterface Interface
 */
class ServiceResult
{

    /**
     * @var
     */
    private $items;

    /**
     * @var
     */
    private $total;

    /**
     * @var
     */
    private $domainModels;

    /**
     * @param $result
     */
    public function __construct($result, $total)
    {
        $this->items = $result;
        $this->total = (int) $total;
    }

    /**
     * @param $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @param $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @param $models
     */
    public function setDomainModels(array $models)
    {
        $this->domainModels = $models;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        // @todo - if no items were requested, throw an exception
        return $this->items;
    }

    /**
     * return int
     */
    public function getTotal()
    {
        // @todo - if no total was requested, throw an exception
        return $this->total;
    }

    /**
     * @return mixed
     */
    public function getDomainModels()
    {
        return $this->domainModels;
    }

    /**
     * Get a single domain model (always the first)
     * @return mixed|null
     */
    public function getDomainModel()
    {
        $models = $this->getDomainModels();
        if (!empty($models)) {
            return reset($models);
        }
        return null;
    }
}
