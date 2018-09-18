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

namespace MW\EasyFaq\Block\Faq;

use Magento\Framework\View\Element\Template;

/**
 * @api
 */
class Search extends Template
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
     * Faq Factory
     *
     * @var \MW\EasyFaq\Model\FaqFactory
     */
    protected $faqFactory;

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
     * @param \MW\EasyFaq\Model\FaqFactory $faqFactory
     * @param array $data
     */
    public function __construct
    (
        Template\Context $context,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \MW\EasyFaq\Model\FaqCategoryFactory $categoryFactory,
        \MW\EasyFaq\Model\FaqFactory $faqFactory,
        array $data = []
    )
    {
        if($context->getScopeConfig()->getValue('easyfaq/general/layout', \Magento\Store\Model\ScopeInterface::SCOPE_STORE) == \MW\EasyFaq\Model\Source\Config\Layout::ONE_COLUMN){
            $this->setTemplate('MW_EasyFaq::1column/faq.phtml');
        }
        else{
            $this->setTemplate("MW_EasyFaq::faq.phtml");
        }
        $this->jsonHelper = $jsonHelper;
        $this->categoryFactory = $categoryFactory;
        $this->faqFactory = $faqFactory;
        $this->storeManager = $context->getStoreManager();
        $this->scopeConfig = $context->getScopeConfig();
        parent::__construct($context, $data);
    }

    /**
     * Get String data
     *
     * @return string
     */
    public function getDataOneColumnJson()
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