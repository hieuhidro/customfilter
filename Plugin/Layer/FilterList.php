<?php
namespace Hidro\CustomFilter\Plugin\Layer;

use Magento\Catalog\Model\Layer;
use Magento\Catalog\Model\Layer\Filter\FilterInterface;
use Magento\Framework\ObjectManagerInterface;
use Hidro\CustomFilter\Model\Layer\Filter\StyleFilter;

class FilterList
{

    protected $objectManager;

    protected $customFilters = null;
    public function __construct(
        ObjectManagerInterface $objectManager
    ) {
        $this->objectManager = $objectManager;
    }

    /**
     * @param Layer $layer
     * @return FilterInterface[]
     */
    public function getCustomFilters($layer)
    {
        if(null === $this->customFilters) {
            $this->customFilters = [];
            $filter = $this->objectManager->create(
                StyleFilter::class,
                ['layer' => $layer]
            );
            $this->customFilters[] = $filter;
        }
        return $this->customFilters;
    }

    /**
     * @param \Magento\Catalog\Model\Layer\FilterList $subject
     * @param                                         $result
     * @param Layer                                   $layer
     */
    public function afterGetFilters(\Magento\Catalog\Model\Layer\FilterList $subject, $result, Layer $layer)
    {
        $customFilters = $this->getCustomFilters($layer);
        $result = array_merge_recursive($result, $customFilters);
        return $result;
    }
}
