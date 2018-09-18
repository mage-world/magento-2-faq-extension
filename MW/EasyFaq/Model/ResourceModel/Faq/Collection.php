<?php

namespace MW\EasyFaq\Model\ResourceModel\Faq;

/**
 * Class Collection
 * @package MW\EasyFaq\Model\ResourceModel\Faq
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('MW\EasyFaq\Model\Faq', 'MW\EasyFaq\Model\ResourceModel\Faq');
    }

    /**
     * @return Collection
     */
    public function getBySortOrder()
    {
        $this->getSelect()->reset('order');
        return $this->setOrder('sort_order', 'asc');
    }
}