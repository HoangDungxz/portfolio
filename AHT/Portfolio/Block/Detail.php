<?php
namespace AHT\Portfolio\Block;

class Detail extends \Magento\Framework\View\Element\Template
{
	private $_portfolioFactory;
	private $_portfolioRepository;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\AHT\Portfolio\Model\PortfolioFactory $portfolioFactory,
		\AHT\Portfolio\Model\PortfolioRepository $portfolioRepository
	)
	{
		parent::__construct($context);
		$this->_portfolioFactory = $portfolioFactory;
		$this->_portfolioRepository = $portfolioRepository;
	}
	public function getPort()
	{
		$id = $this->getRequest()->getParam('id');
		$portfolio = $this->_portfolioFactory->create();

		if ($id) {
			$portfolio->load($id);
			if (!$portfolio->getId()) {
				$this->messageManager->addError(__('This Portfolio no longer exists.'));
				/** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
				$resultRedirect = $this->resultRedirectFactory->create();
				return $resultRedirect->setPath('*/*/');
			}
		}
		return $portfolio;
	}
}