<?php

namespace MW\EasyFaq\Model\Source\Listing\Column\Option;

/**
 * Class Store
 * @package MW\EasyFaq\Model\Source\Listing\Column\Option
 */
class Store extends \Magento\Store\Ui\Component\Listing\Column\Store
{
    /**
     * Get data
     *
     * @param array $item
     * @return string
     */
    protected function prepareItem(array $item)
    {
        $content = '';
        $origStores = '';
        if (!empty($item[$this->storeKey])) {
            $origStores = $item[$this->storeKey];
        }

        if ($origStores == 0) {
            return __('All Store Views');
        }

        if (!$origStores) {
            return '';
        }

        $origStores = array_unique(explode(',', $origStores));

        if (empty($origStores)) {
            return '';
        }
        if (!is_array($origStores)) {
            $origStores = [$origStores];
        }
        if (in_array(0, array_values($origStores)) && count($origStores) == 1) {
            return __('All Store Views');
        }

        $data = $this->systemStore->getStoresStructure(false, $origStores);

        foreach ($data as $website) {
            $content .= $website['label'] . "<br/>";
            foreach ($website['children'] as $group) {
                $content .= str_repeat('&nbsp;', 3) . $this->escaper->escapeHtml($group['label']) . "<br/>";
                foreach ($group['children'] as $store) {
                    $content .= str_repeat('&nbsp;', 6) . $this->escaper->escapeHtml($store['label']) . "<br/>";
                }
            }
        }

        return $content;
    }

//    public function toOptionArray()
//    {
//        $options = [];
//        $options
//    }
}