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
 * Class Save
 * @package MW\EasyFaq\Controller\Adminhtml\Category
 */
class Save extends Action
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
        if ($this->getRequest()->getPostValue()) {
            /** @var \MW\EasyFaq\Model\FaqCategory $model */
            $model = $this->_objectManager->create('MW\EasyFaq\Model\FaqCategory');

            try {
                $data = $this->getRequest()->getPostValue();
                if (isset($data['category_id']) && $id = $data['category_id']) {
                    $model = $model->load($id);
                } else {
                    unset($data['category_id']);
                }
                $model->setData($data);

                $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData($data);
                $model->save();
                $this->messageManager->addSuccess(__('You saved the category.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setPageData(false);
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    __('Something went wrong while saving the category data. Please review the error log.')
                );
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('category_id')]);
                return;
            }
        }
        $this->_redirect('*/*/');
    }
}