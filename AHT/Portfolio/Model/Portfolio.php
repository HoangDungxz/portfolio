<?php
namespace AHT\Portfolio\Model;

use AHT\Portfolio\Api\Data\PortfolioInterface;

class Portfolio extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface, PortfolioInterface
{
	const CACHE_TAG = 'portfolio';

	protected $_cacheTag = 'portfolio';

	protected $_eventPrefix = 'portfolio';

	protected function _construct()
	{
		$this->_init('AHT\Portfolio\Model\ResourceModel\Portfolio');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
}