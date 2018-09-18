<?php

namespace MW\EasyFaq\Model\Source\Listing\Column\Option;

/**
 * Class Status
 * @package MW\EasyFaq\Model\Source\Listing\Column\Option
 */
class Status implements \Magento\Framework\Data\OptionSourceInterface
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        $options = array();
        foreach (self::getOptionHash() as $value => $label) {
            $options[] = array(
                'value'    => $value,
                'label'    => $label
            );
        }
        return $options;
    }

    /**
     * get available statuses.
     *
     * @return []
     */
    public static function getOptionHash()
    {
        return [
            self::STATUS_ENABLED => __('Enabled')
            , self::STATUS_DISABLED => __('Disabled'),
        ];
    }
}