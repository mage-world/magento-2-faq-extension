<?php
/**
 * Mage-World
 *
 *  @category    Mage-World
 *  @package     MW
 *  @author      Mage-world Developer
 *
 *  @copyright   Copyright (c) 2018 Mage-World (https://www.mage-world.com/)
 */
namespace MW\EasyFaq\Ui\DataProvider\Form;
use MW\EasyFaq\Model\ResourceModel\Faq\CollectionFactory;

/**
 * Class FaqProvider
 * @package MW\EasyFaq\Ui\DataProvider\Form
 */
class FaqProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

    /**
     * @var CollectionFactory
     */
    protected $faqCollectionFactory;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $faqCollectionFactory,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->faqCollectionFactory = $faqCollectionFactory;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $faqCollectionFactory->create();
        $this->_request = $request;
        $this->dataPersistor = $dataPersistor;
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

        $itemId = $this->_request->getParam('id');
        $this->collection = $this->faqCollectionFactory->create();
        if (!empty($itemId)) {
            $items = $this->collection->getItems();
            foreach ($items as $item) {
                $this->loadedData[$item->getFaqId()] = $item->getData();
            }

            $data = $this->dataPersistor->get('faq_category');
            if (!empty($data)) {
                $page = $this->collection->getNewEmptyItem();
                $page->setData($data);
                $this->loadedData[$page->getFaqId()] = $page->getData();
                $this->dataPersistor->clear('faq_category');
            }
        }
        return $this->loadedData;
    }
}