<?php

namespace AHT\Portfolio\Model\Portfolio;

use AHT\Portfolio\Model\ResourceModel\Portfolio\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ObjectManager;
use AHT\Portfolio\Model\Portfolio\FileInfo;
use Magento\Framework\Filesystem;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \AHT\Portfolio\Model\ResourceModel\AHT\Portfolio\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var Filesystem
     */
    private $fileInfo;

    protected $_storeManager;   

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $portfolioCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $portfolioCollectionFactory,
        DataPersistorInterface $dataPersistor,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $portfolioCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->_storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();


        /** @var \AHT\Portfolio\Model\Banner $banner */
        foreach ($items as $banner) {
            $banner = $this->convertValues($banner);

            $this->loadedData[$banner->getId()] = $banner->getData();
        }

        // Used from the Save action
        $data = $this->dataPersistor->get('index');

        if (!empty($data)) {
            $banner = $this->collection->getNewEmptyItem();

            $banner->setData($data);
            $this->loadedData[$banner->getId()] = $banner->getData();


            $this->dataPersistor->clear('index');
        }
        return $this->loadedData;
    }

    /**
     * Converts image data to acceptable for rendering format
     *
     * @param \AHT\Portfolio\Model\Banner $banner
     * @return \AHT\Portfolio\Model\Banner $banner
     */
    private function convertValues($banner)
    {
        $fileName = $banner->getImages();



        $image = [];
        if ($this->getFileInfo()->isExist($fileName)) {
            $stat = $this->getFileInfo()->getStat($fileName);
            $mime = $this->getFileInfo()->getMimeType($fileName);
            $image[0]['name'] = $fileName;
            $image[0]['url'] = $this->_storeManager->getStore()->getBaseUrl()."pub/media/portfolio/index/".$fileName;
            $image[0]['size'] = isset($stat) ? $stat['size'] : 0;
            $image[0]['type'] = $mime;
        }
        $banner->setImage($image);

        return $banner;
    }

    /**
     * Get FileInfo instance
     *
     * @return FileInfo
     *
     * @deprecated 101.1.0
     */
    private function getFileInfo()
    {
        if ($this->fileInfo === null) {
            $this->fileInfo = ObjectManager::getInstance()->get(FileInfo::class);
        }
        return $this->fileInfo;
    }
}