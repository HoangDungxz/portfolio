<?php

namespace AHT\Portfolio\Controller\Adminhtml\Index;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;
    protected $_postFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $coreRegistry,
        \AHT\Portfolio\Model\PortfolioFactory $postFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_postFactory = $postFactory;
        parent::__construct($context);
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');


        $model = $this->_postFactory->create();


        // 2. Initial checking
        if ($id) {
            $model->load($id);

            if (!$model->getId()) {
                $this->messageManager->addError(__('This Portfolio no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('portfolio', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(
            'Portfolio::index'
        )->addBreadcrumb(
            __('Portfolio Slider'), __('Portfolio Slider')
        )->addBreadcrumb(
            __('All Portfolio'), __('All Portfolio')
        )->addBreadcrumb(
            $id ? __('Edit Portfolio') : __('New Portfolio'),
            $id ? __('Edit Portfolio') : __('New Portfolio')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('All Portfolio'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getName() : __('New Portfolio'));
        return $resultPage;
    }

    /**
     * Authorization level of a basic admin session
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Portfolio::index') || $this->_authorization->isAllowed('Portfolio::create');
    }
}




