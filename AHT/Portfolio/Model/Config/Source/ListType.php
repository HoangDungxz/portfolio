<?php
namespace Meetanshi\CustomWidget\Model\Config\Source;

class Gender implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'slide', 'label' => __('Slider')],
            ['value' => 'list', 'label' => __('List')]];
    }
}