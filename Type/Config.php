<?php declare(strict_types=1);

namespace VMPL\PopupManagement\Type;

enum Config : string
{
    case Delay = 'cms/popup/delay';
    case Timeout = 'cms/popup/timeout';
    case Count = 'cms/popup/count';
    case ClickableOverlay = 'cms/popup/clickableOverlay';
    case PopupType = 'cms/popup/type';

    public function getFieldName(): string
    {
        $components = explode('/', $this->value);
        return array_pop($components);
    }
}
