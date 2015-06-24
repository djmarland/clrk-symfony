<?php

namespace DatabaseBundle\Query;

use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * QueryInterface Interface
 */
class QueryResult
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
    public function __construct($result, $total = null)
    {
        if (!is_array($result)) {
            $result = [$result];
        }
        $this->items = $result;
        if (!is_null($total)) {
            $this->total = (int)$total;
        }
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
        if (is_null($this->total)) {
            // @todo - throw a better exception
            throw new \Exception('Tried to call total when no count had been asked for');
        }
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
