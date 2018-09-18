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

namespace MW\EasyFaq\Controller\Adminhtml\Faq;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;

/**
 * Class Edit
 * @package MW\EasyFaq\Controller\Adminhtml\Faq
 */
class Edit extends Action
{
    /**
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $_eventManager;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $_resultForwardFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $_resultLayoutFactory;

    /**
     * @var \Magento\Framework\Logger\Monolog
     */
    protected $_logger;

    /**
     * AbstractAction constructor.
     *
     * @param Context $context
     * @param \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_eventManager = $context->getEventManager();
        $this->_resultPageFactory = $resultPageFactory;
        $this->_resultLayoutFactory = $resultLayoutFactory;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $id = $this->getFaqId();
        if ($id) {
            try {
                $model = $this->_objectManager->create('MW\EasyFaq\Model\Faq')->load($id);
            } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
                $this->messageManager->addError(__('This FAQ no longer exists.'));
                $this->_redirect('*/*/*');
                return;
            }
        } else {
            /** @var \MW\EasyFaq\Model\Faq $model */
            $model = $this->_objectManager->create('MW\EasyFaq\Model\Faq');
        }
        // set entered data if was error when we do save
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getPageData(true);
        if (!empty($data)) {
            $model->addData($data);
        }

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('MW_EasyFaq::faq_item');
        $resultPage->getConfig()->getTitle()->prepend(__('New FAQ'));
        if ($id) {
            $resultPage->getConfig()->getTitle()->prepend(__('Edit FAQ'));
        }
        $resultPage->addBreadcrumb(__('Easy FAQ'), __('Easy FAQ'));
        $resultPage->addBreadcrumb(__('Manage FAQ'), __('Manage FAQ'));

        return $resultPage;
    }

    protected function getFaqId()
    {
        return $this->getRequest()->getParam('id');
    }
}