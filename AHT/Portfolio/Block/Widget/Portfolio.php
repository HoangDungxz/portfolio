<?php 
namespace AHT\Portfolio\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use AHT\Portfolio\Model\Portfolio as portfolioCollection;
use Magento\Framework\App\Config\ScopeConfigInterface;


/**
 * summary
 */
class Portfolio extends Template
{

    protected $portfolioCollection;
    protected $scopeConfig;
    public function __construct(Context $context, portfolioCollection $portfolioCollection,ScopeConfigInterface $scopeConfig)
    {
        $this->portfolioCollection = $portfolioCollection;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }
    public function getConfig($val)
    {
        return $this->scopeConfig->getValue($val, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

    }


    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
    public function getPortfolioCollection()
    {
        $collection = $this->portfolioCollection->getCollection();
        $collection->setPageSize($this->getData('number_of_display'));
        return $collection;
    }
}

?>