<?php
namespace Hidro\CustomFilter\Model\Layer\Filter;

use Magento\Catalog\Model\Layer\Filter\AbstractFilter;
use Magento\Framework\App\RequestInterface;

class StyleFilter extends AbstractFilter
{
    public function apply(RequestInterface $request)
    {
        //Always add this filter to product list collection on Category.
        if ($this->canApply($request)) {
            //Add style jacket to filter
            //style_general is Style's attribute code
            //5544 is Jacket's option id.
            $this->getLayer()
                ->getProductCollection()
                ->addFieldToFilter('style_general', 5544);

            //Add this filter to state
            //Comment this line remove the this filter on state.
            $this->getLayer()->getState()->addFilter($this->_createItem($this->getOptionText(null),5544, 0));
        }
        return $this;
    }

    public function getName()
    {
        //Filter name on state
        return __('Filter name');
    }

    public function getOptionText($optionId)
    {
        //Filter value on stage
        return 'Option text';
    }

    /**
     * @return int
     */
    public function getItemsCount()
    {
        //Ignore the parent logic
        return 0;
    }

    /**
     * @param RequestInterface $request
     * @return bool
     */
    public function canApply($request)
    {
        //We will ignore the logic, if end-user filter the products by Style
        return !$request->getParam($this->getRequestVar());
    }
}
