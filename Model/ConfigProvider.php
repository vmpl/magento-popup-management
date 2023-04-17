<?php declare(strict_types=1);

namespace VMPL\PopupManagement\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use VMPL\PopupManagement\Type\Config as ConfigTypes;

/**
 * Class used to get store configuration preferences or other settings
 */
class ConfigProvider
{
    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        protected readonly ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * @param ConfigTypes $type
     * @param $storeId
     * @return mixed
     */
    public function getByType(ConfigTypes $type, $storeId = null): mixed
    {
        return $this->scopeConfig->getValue($type->value,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
