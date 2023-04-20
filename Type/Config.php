<?php declare(strict_types=1);

namespace VMPL\PopupManagement\Type;

enum Config : string
{
    case Delay = 'cms/popup/delay';
    case Timeout = 'cms/popup/timeout';
    case Count = 'cms/popup/count';
    case ClickableOverlay = 'cms/popup/clickableOverlay';
    case PopupType = 'cms/popup/type';
    case HashTriggerRegex = 'cms/popup/hashTriggerRegex';

    public function getFieldName(): string
    {
        $components = explode('/', $this->value);
        return array_pop($components);
    }

    public function isStoreFrontAvalible(): bool
    {
        switch ($this) {
            case self::Delay:
            case self::Timeout:
            case self::Count:
            case self::ClickableOverlay:
            case self::PopupType:
            case self::HashTriggerRegex:
                return true;
            default:
                return false;
        }
    }

    public static function getCaseNames(): array
    {
        return array_map(function ($case) {
            return $case->name;
        }, static::cases());
    }
}
