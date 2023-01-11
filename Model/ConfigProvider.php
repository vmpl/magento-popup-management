<?php declare(strict_types=1);

namespace VMPL\PopupManagement\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use VMPL\PopupManagement\Type\Config as ConfigTypes;

class ConfigProvider
{
    public function __construct(
        protected readonly ScopeConfigInterface $scopeConfig
    ) {
    }

    public function getConfig(ConfigTypes $type, $storeId = null)
    {
        return $this->scopeConfig->getValue($type->value,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
