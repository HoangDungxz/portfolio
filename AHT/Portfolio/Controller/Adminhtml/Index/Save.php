<?php


namespace AHT\Portfolio\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\TestFramework\Inspection\Exception;
use AHT\Portfolio\Model\Portfolio\ImageUploader;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var ImageUploader
     */
    protected $imageUploader;

    protected $_postFactory;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        ImageUploader $imageUploader, 
        \AHT\Portfolio\Model\PortfolioFactory $postFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->imageUploader = $imageUploader;
        $this->_postFactory = $postFactory;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $id = $this->getRequest()->getParam('id');


            if (empty($data['id'])) {
                $data['id'] = null;
            }

            if (isset($data['images'])) {
                $imageName = $data['images'];
            }
            if (isset($data['image'][0]['name'])) {
                
                $imageName = $data['image'][0]['name'];
            }

            $model = $this->_postFactory->create()->load($id);

            if (!$model->getId() && $id) {
                $this->messageManager->addError(__('This Portfolio no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            $data['images'] = $imageName;

            $model->setData($data);

            try {
                $model->save();
                if ($imageName) {
                    $this->imageUploader->moveFileFromTmp($imageName);
                }
                $this->messageManager->addSuccess(__('You saved the Portfolio.'));
                $this->dataPersistor->clear('portfolio');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Portfolio.'));
            }

            $this->dataPersistor->set('portfolio', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Authorization level of a basic admin session
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Portfolio::update') || $this->_authorization->isAllowed('Portfolio::create');
    }
}