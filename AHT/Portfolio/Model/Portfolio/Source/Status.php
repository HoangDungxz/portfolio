<?php


namespace AHT\Portfolio\Model\Portfolio\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Status
 */
class Status implements OptionSourceInterface
{
    /**
     * @var \PHPCuong\BannerSlider\Model\Banner
     */
    protected $portfolio;

    /**
     * Constructor
     *
     * @param \AHT\Portfolio\Model\Portfolio$portfolio
     */
    public function __construct(\AHT\Portfolio\Model\Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->portfolio->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}