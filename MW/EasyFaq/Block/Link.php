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

namespace MW\EasyFaq\Block;

use Magento\Framework\View\Element\Template;

/**
 * Class Link
 * @package MW\EasyFaq\Block
 */
class Link extends \Magento\Framework\View\Element\Html\Link
{
    /**
     * Scope config
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct
    (
        Template\Context $context,
        array $data = []
    )
    {
        $this->scopeConfig = $context->getScopeConfig();
        parent::__construct($context, $data);
    }

    /**
     * Render block HTML.
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->scopeConfig->getValue('easyfaq/general/enable', \Magento\Store\Model\ScopeInterface::SCOPE_STORE)) {
            return '';
        }
        return '<li><a ' . $this->getLinkAttributes() . ' >' . $this->escapeHtml($this->getLabel()) . '</a></li>';
    }
}