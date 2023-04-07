<?php declare(strict_types=1);

namespace VMPL\PopupManagement\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Option Source for system
 */
class PopupTypes implements OptionSourceInterface
{
    /**
     * @return array<string, mixed>
     */
    public function toOptionArray()
    {
        return array_map(function ($case) {
            return ['value' => $case->value, 'label' => __($case->name)];
        }, \VMPL\PopupManagement\Type\Popup::cases());
    }
}
