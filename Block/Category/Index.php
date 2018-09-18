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

namespace MW\EasyFaq\Block\Category;

use Magento\Framework\View\Element\Template;

/**
 * Class Index
 * @package MW\EasyFaq\Block\Category
 */
class Index extends Template
{
    /**
     * Json Helper
     *
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $jsonHelper;

    /**
     * FAQ Category Factory
     *
     * @var \MW\EasyFaq\Model\FaqCategoryFactory
     */
    protected $categoryFactory;

    /**
     * Store Manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Scope config
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param \MW\EasyFaq\Model\FaqCategoryFactory $categoryFactory
     * @param array $data
     */
    public function __construct
    (
        Template\Context $context,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \MW\EasyFaq\Model\FaqCategoryFactory $categoryFactory,
        array $data = []
    )
    {
        $this->jsonHelper = $jsonHelper;
        $this->categoryFactory = $categoryFactory;
        $this->storeManager = $context->getStoreManager();
        $this->scopeConfig = $context->getScopeConfig();
        parent::__construct($context, $data);
    }

    /**
     * Get Faq Category Collection
     *
     * @return \MW\EasyFaq\Model\ResourceModel\FaqCategory\Collection
     */
    public function getCategories()
    {
        $storeIds = [0];
        array_push($storeIds, $this->storeManager->getStore()->getStoreId());
        return $this->categoryFactory->create()
            ->getCollection()
            ->addFieldToFilter('status',1)
            ->addFieldToFilter('store_id',array('in'=>$storeIds))
            ->getBySortOrder();
    }

    /**
     * Get String data
     *
     * @return string
     */
    public function getCategoriesJsData()
    {
        return $this->jsonHelper->jsonEncode($this->getCategories()->getData());
    }

    /**
     * Get Image Loading Url
     *
     * @return string
     */
    public function getLoadingPath()
    {
        return $this ->getViewFileUrl('images/loader-2.gif');
    }

    /**
     * Get Ajax type
     *
     * @return bool
     */
    public function isAjaxPageType()
    {
        $pageStyleConfig = $this->scopeConfig->getValue('easyfaq/general/page_type', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if($pageStyleConfig == \MW\EasyFaq\Model\Source\Config\PageType::AJAX){
            return true;
        }
        return false;
    }
}