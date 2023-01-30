<?php declare(strict_types=1);

namespace VMPL\PopupManagement\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class PopupTypes implements OptionSourceInterface
{
    public function toOptionArray()
    {
        return array_map(function ($case) {
            return ['value' => $case->value, 'label' => __($case->name)];
        }, \VMPL\PopupManagement\Type\Popup::cases());
    }
}
