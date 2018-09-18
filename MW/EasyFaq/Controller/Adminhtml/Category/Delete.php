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

namespace MW\EasyFaq\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;

/**
 * Class Delete
 * @package MW\EasyFaq\Controller\Adminhtml\Category
 */
class Delete extends Action
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
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $model = $this->_objectManager->create('MW\EasyFaq\Model\FaqCategory')->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('Category has been deleted.'));
                $this->_redirect('*/*/');
                return;
            } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
                $this->messageManager->addError(__('Cannot delete this Category.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        $this->messageManager->addError(__('No Category to delete.'));
        $this->_redirect('*/*/');
        return;
    }
}