<?php declare(strict_types=1);

namespace VMPL\PopupManagement\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use VMPL\PopupManagement\Type\Config as ConfigTypes;

class Config
{
    public function __construct(
        protected readonly ScopeConfigInterface $scopeConfig
    ) {
    }

    public function getDelayTimePopup($storeId = null): int
    {
        return (int)$this->scopeConfig->getValue(
            ConfigTypes::Delay->value,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getTimeout($storeId = null): int
    {
        return (int)$this->scopeConfig->getValue(
            ConfigTypes::Timeout->value,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getCount($storeId = null): int
    {
        return (int)$this->scopeConfig->getValue(
            ConfigTypes::Count->value,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getClickableOverlay($storeId = null): bool
    {
        return (bool)$this->scopeConfig->getValue(
            ConfigTypes::ClickableOverlay->value,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getPopupType($storeId = null): string
    {
        return (string)$this->scopeConfig->getValue(
            ConfigTypes::PopupType->value,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getByType(\VMPL\PopupManagement\Type\Config $type, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $type->value,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
