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

namespace MW\EasyFaq\Block\Adminhtml\FaqCategory\Edit\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\View\Element\UiComponent\Context as UiContext;

/**
 * Class Delete
 * @package MW\EasyFaq\Block\Adminhtml\FaqCategory\Edit\Buttons
 */
class Delete extends \Magento\Backend\Block\Template implements ButtonProviderInterface
{
    /**
     * @var Context
     */
    protected $context;

    protected $uiContext;

    /**
     * @param Context $context
     */
    public function __construct(
        Context $context,
        UiContext $uiContext
    ) {
        $this->context = $context;
        $this->uiContext = $uiContext;
    }

    /**
     * get button data
     *
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        if ($categoryId = $this->context->getRequest()->getParam('id')) {
            $url = $this->uiContext->getUrl('*/*/delete', ['id'=>$categoryId]);
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => sprintf("deleteConfirm(
                    'Are you sure you want to delete this Category?', 
                    '%s'
                )", $url),
                'sort_order' => 20,
            ];
        }
        return $data;
    }
}