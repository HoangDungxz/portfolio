<?php

namespace AHT\Portfolio\Controller\Adminhtml\Index;

class NewAction extends \Magento\Backend\App\Action
{



    protected $resultForwardFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }


    public function execute()
    {

        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Portfolio::create');
    }
}