<?php
namespace AHT\Portfolio\Block\Adminhtml;

class Portfolio extends \Magento\Backend\Block\Widget\Grid\Container
{
	protected function _construct()
	{

		$this->_blockGroup = 'AHT_Portfolio';
		$this->_controller = 'adminhtml_portfolio';
		parent::_construct();
	}
}