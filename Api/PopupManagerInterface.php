<?php declare(strict_types=1);

namespace VMPL\PopupManagement\Api;

use Magento\Framework\View\LayoutInterface;

interface PopupManagerInterface
{
    public function appendPopupByIdentifier(string $identifier, LayoutInterface $layout): void;
}
