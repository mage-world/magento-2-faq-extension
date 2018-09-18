<?php

namespace MW\EasyFaq\Controller\Category;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

/**
 * Class GetFaq
 * @package MW\EasyFaq\Controller\Category
 */
class GetFaq extends Action
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
     * AbstractAction constructor.
     *
     * @param Context $context
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param \MW\EasyFaq\Model\FaqFactory $faqFactory
     */
    public function __construct
    (
        Context $context,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \MW\EasyFaq\Model\FaqFactory $faqFactory
    )
    {
        $this->jsonHelper = $jsonHelper;
        $this->faqFactory = $faqFactory;
        parent::__construct($context);
    }

    /**
     * @return string
     */
    public function execute()
    {
        $categoryId = $this->getRequest()->getParam('category_id', 0);
        $faqJsonData = $this->getFaqByCategoryJsData($categoryId);
        $this->getResponse()->setBody($faqJsonData);
    }

    /**
     * @return string
     */
    public function getFaqByCategoryJsData($categoryId)
    {
        $data = [];
        $dataJs = [];
        if($categoryId){
            $faqs = $this->faqFactory->create()->getFaqByCategoryId($categoryId)
                ->addFieldToFilter('status',1)
                ->getBySortOrder();
            $data['category_id'] = $categoryId;
            $data['faq_items'] = $faqs->getData();
            $dataJs[] = $data;
            return $this->jsonHelper->jsonEncode($dataJs);
        }
    }
}