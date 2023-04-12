<?php declare(strict_types=1);

namespace VMPL\PopupManagement\Model\Config\Source\PopupTypes;

use VMPL\PopupManagement\Model\Config\Source\PopupTypes;

/**
 * Types with default store configuration options
 */
class WithDefault extends PopupTypes
{
    /**
     * @return array<string, mixed>
     */
    public function toOptionArray()
    {
        $options = parent::toOptionArray();
        array_unshift($options, ['value' => 'default', 'label' => __('System Configuration')]);
        return $options;
    }
}
