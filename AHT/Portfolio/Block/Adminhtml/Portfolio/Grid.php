<?php
namespace AHT\Portfolio\Block\Adminhtml\Portfolio;

use Magento\Backend\Block\Widget\Grid as WidgetGrid;
use   Magento\Core\Helper\Data;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
	/* @var \AHT\Portfolio\Model\Resource\Portfolio\Collection */
	protected $_portfolioCollection;
	/*
	@param \Magento\Backend\Block\Template\Context $context
	@param \Magento\Backend\Helper\Data $backendHelper
	@param
	\AHT\Portfolio\Model\ResourceModel\Portfolio\Collection
	$portfolioCollection
	@param array $data
	*/
	public function __construct(
		\Magento\Backend\Block\Template\Context $context,
		\Magento\Backend\Helper\Data $backendHelper,
		\AHT\Portfolio\Model\ResourceModel\Portfolio\Collection $portfolioCollection,
		array $data = []
	) {
		$this->_portfolioCollection = $portfolioCollection;



		parent::__construct($context, $backendHelper, $data);
		$this->setEmptyText(__('No Portfolio Found'));
	}
	/*
	Initialize the Portfolio collection@return WidgetGrid
	*/
	protected function _prepareCollection()
	{
		$this->setCollection($this->_portfolioCollection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn(
			'id',
			[
				'header' => __('ID'),
				'sortable' => true,
				'index' => 'id'
			]
		);
		$this->addColumn(
			'title',
			[
				'header' => __('Title'),
				'sortable' => true,
				'index' => 'title'
			]
		);
		$this->addColumn(
			'images',
			array(
				'header' => __('Images'),
				'index' => 'images',
				'renderer'  => '\AHT\Portfolio\Block\Adminhtml\Portfolio\Grid\Renderer\Image',
			)
		);
		$this->addColumn(
			'description',
			[
				'header' => __('Description'),
				'index' => 'description'
			]
		);	
		$this->addColumn(
			'edit',
			[
				'header' => __('Action'),
				'type' => 'action',
				'getter' => 'getId',
				'actions' => [
					[
						'caption' => __('Edit'),
						'url' => [
							'base' => '*/*/edit',
							'params' => []
						],
						'field' => 'id'
					]
				],
				'filter' => false,
				'sortable' => false,
				'label' =>  __('Edit'),
				'index' => 'stores',
				'header_css_class' => 'col-action',
				'column_css_class' => 'col-action'
			]
		);   


		return parent::_prepareColumns();
	}


	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('id');

		$this->getMassactionBlock()->setFormFieldName('id');

		$this->getMassactionBlock()->addItem('delete', array(
			'label'   => 'Delete',
			'url'     => $this->getUrl('*/index/massdelete'),
			'confirm' => 'Are you sure?',
		));
	}
}