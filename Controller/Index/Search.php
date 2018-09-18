<?php

namespace MW\EasyFaq\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

/**
 * Class Search
 * @package MW\EasyFaq\Controller\Index
 */
class Search extends Action
{
    /**
     * @var \MW\EasyFaq\Model\FaqFactory
     */
    protected $faqFactory;

    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $jsonHelper;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \MW\EasyFaq\Model\FaqCategoryFactory
     */
    protected $categoryFactory;

    /**
     * AbstractAction constructor.
     *
     * @param Context $context
     * @param \Magento\Framework\Json\Helper\Data $jsonHelpe
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \MW\EasyFaq\Model\FaqCategoryFactory $categoryFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \MW\EasyFaq\Model\FaqFactory $faqFactory
     */
    public function __construct
    (
        Context $context,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \MW\EasyFaq\Model\FaqCategoryFactory $categoryFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \MW\EasyFaq\Model\FaqFactory $faqFactory
    )
    {
        $this->jsonHelper = $jsonHelper;
        $this->faqFactory = $faqFactory;
        $this->scopeConfig = $scopeConfig;
        $this->categoryFactory = $categoryFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * @return string
     */
    public function execute()
    {
        $searchKey = $this->getRequest()->getParam('key_search', '');
        $layoutConfig = $this->scopeConfig->getValue('easyfaq/general/layout', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $faqJsonData = $this->getFaqSearchJsData($searchKey);
        $this->getResponse()->setBody($faqJsonData);
    }

    /**
     * @return string
     */
    public function getFaqSearchJsData($searchKey)
    {
        $data = [];
        $data['name'] = __("Search Result");
        $data['category_id'] = 0;
        $faqs = $this->faqFactory->create()->getCollection()
            ->addFieldToFilter('status',1)
            ->getBySortOrder();
        if($searchKey){
            $faqs->addFieldToFilter(
                array(
                    'question',
                    'answer'
                ),
                array(
                    array('like' => "%".$searchKey."%"),
                    array('like' => "%".$searchKey."%")
                )
            );
        }
        else{
            return $this->getDefaultDataJson();
        }
        $data['faq_items'] = $faqs->getData();
        $dataJS = [];
        $dataJS[] = $data;
        return $this->jsonHelper->jsonEncode($dataJS);
    }

    /**
     * @return string
     */
    public function getDefaultDataJson()
    {
        $storeIds = [0];
        array_push($storeIds, $this->storeManager->getStore()->getStoreId());
        $data = [];
        $i = 0;
        $categories = $this->categoryFactory->create()
            ->getCollection()
            ->addFieldToFilter('status',1)
            ->addFieldToFilter('store_id',array('in'=>$storeIds))
            ->getBySortOrder();
        foreach($categories as $val){
            $data[$i] = $val->getData();
            $data[$i]['faq_items'] = $this->faqFactory->create()->getFaqByCategoryId($val->getCategoryId())
                ->getBySortOrder()->getData();
            $i++;
        }
        return $this->jsonHelper->jsonEncode($data);
    }
}