<?php declare(strict_types=1);

namespace VMPL\PopupManagement\Model\Config\Source;

/**
 * Yes and No, config options with default store configuration option
 */
class YesnoWithConfig extends \Magento\Config\Model\Config\Source\Yesno
{
    /**
     * @return array<string, mixed>
     */
    public function toOptionArray()
    {
        $options = [];
        foreach ($this->toArray() as $value => $label) {
            $options[] = ['value' => $value, 'label' => $label];
        }
        return $options;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = parent::toArray();
        $array['default'] = __('System Configuration');
        return $array;
    }
}
