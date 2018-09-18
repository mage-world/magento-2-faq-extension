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

namespace MW\EasyFaq\Model\ResourceModel\FaqCategory;
/**
 * Class Collection
 * @package MW\EasyFaq\Model\ResourceModel\FaqCategory
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
        $this->_init('MW\EasyFaq\Model\FaqCategory', 'MW\EasyFaq\Model\ResourceModel\FaqCategory');
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