<?php 
namespace AHT\Portfolio\Model\Config\Source;

class ListTemplate implements \Magento\Framework\Option\ArrayInterface
{
 public function toOptionArray()
 {
  return [
    ['value' => 'carousel', 'label' => __('Carousel')],
    ['value' => 'list', 'label' => __('List Only')]
  ];
 }
}
