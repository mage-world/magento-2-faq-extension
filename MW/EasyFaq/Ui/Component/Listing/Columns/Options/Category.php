<?php

namespace MW\EasyFaq\Ui\Component\Listing\Columns\Options;

/**
 * Class Category
 * @package MW\EasyFaq\Ui\Component\Listing\Columns\Options
 */
class Category implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var \MW\EasyFaq\Model\ResourceModel\FaqCategory\CollectionFactory
     */
    protected $collection;

    /**
     * Category constructor.
     * @param \MW\EasyFaq\Model\ResourceModel\FaqCategory\CollectionFactory $collectionFactory
     */
    public function __construct
    (
        \MW\EasyFaq\Model\ResourceModel\FaqCategory\CollectionFactory $collectionFactory
    )
    {
        $this->collection = $collectionFactory;
    }

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        $categories = $this->collection->create();
        $options = [];
        foreach ($categories as $cat){
            $options[] = [
                'value' => $cat->getCategoryId(),
                'label' => $cat->getName()
            ];
        }

        return $options;
    }
}