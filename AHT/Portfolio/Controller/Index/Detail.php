<?php
namespace AHT\Portfolio\Controller\Index;

class Detail extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    protected $_portfolioFactory;
    

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \AHT\Portfolio\Model\PortfolioFactory $portfolioFactory

    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_portfolioFactory = $portfolioFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        // $id = $this->getRequest()->getParam('id');


        // $model = $this->_portfolioFactory->create();


        // // 2. Initial checking
        // if ($id) {
        //     $model->load($id);

        //     if (!$model->getId()) {
        //         $this->messageManager->addError(__('This Portfolio no longer exists.'));
        //         * @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect 
        //         $resultRedirect = $this->resultRedirectFactory->create();
        //         return $resultRedirect->setPath('*/*/');
        //     }
        // }

        return $this->_pageFactory->create();
    }
}