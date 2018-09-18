<?php
namespace MW\EasyFaq\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use \Magento\Framework\Exception\NotFoundException;

/**
 * Class Index
 * @package MW\EasyFaq\Controller\Index
 */
class Index extends Action
{

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * AbstractAction constructor.
     *
     * @param Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param PageFactory $resultPageFactory
     */
    public function __construct
    (
        Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        PageFactory $resultPageFactory
    )
    {
        $this->_resultPageFactory = $resultPageFactory;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        if(!$this->scopeConfig->getValue('easyfaq/general/enable', \Magento\Store\Model\ScopeInterface::SCOPE_STORE)){
            throw new NotFoundException(__('Parameter is incorrect.'));
        }
        $resultPage = $this->_resultPageFactory->create();

        $metaTitleConfig = $this->scopeConfig->getValue('easyfaq/general/meta_title', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $metaKeywordsConfig = $this->scopeConfig->getValue('easyfaq/general/meta_keywords', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $metaDescriptionConfig = $this->scopeConfig->getValue('easyfaq/general/meta_description', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $pageTitle = $this->scopeConfig->getValue('easyfaq/general/page_title', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $layoutConfig = $this->scopeConfig->getValue('easyfaq/general/layout', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if($layoutConfig == \MW\EasyFaq\Model\Source\Config\Layout::ONE_COLUMN){
            $resultPage->addHandle('easyfaq_1column_index');
        }
        else if($layoutConfig == \MW\EasyFaq\Model\Source\Config\Layout::TWO_COLUMN_RIGHT){
            $resultPage->addHandle('easyfaq_2right_index');
        }
        else if($layoutConfig == \MW\EasyFaq\Model\Source\Config\Layout::TWO_COLUMN_LEFT){
            $resultPage->addHandle('easyfaq_2left_index');
        }

        $resultPage->getConfig()->getTitle()->set($metaTitleConfig);
        $resultPage->getConfig()->setDescription($metaKeywordsConfig);
        $resultPage->getConfig()->setKeywords($metaDescriptionConfig);

        $pageMainTitle = $resultPage->getLayout()->getBlock('page.main.title');
        if ($pageMainTitle && $pageMainTitle instanceof \Magento\Theme\Block\Html\Title) {
            $pageMainTitle->setPageTitle($pageTitle);
        }

        return $resultPage;
    }
}