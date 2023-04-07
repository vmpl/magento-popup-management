<?php declare(strict_types=1);

namespace VMPL\PopupManagement\Block\Widget;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Widget\Block\BlockInterface;
use VMPL\PopupManagement\Helper\Config;

/**
 * Block of the widget
 */
class CmsPopup extends \Magento\Cms\Block\Widget\Block implements BlockInterface, IdentityInterface
{
    /**
     * @return string
     */
    public function getGeneratedId(): string
    {
        $id = $this->getBlock()?->getId() ?? '';
        $id .= $this->getNameInLayout();
        return md5($id);
    }

    public function getWidgetParam(\VMPL\PopupManagement\Type\Config $config)
    {
        return $this->getData($config->getFieldName()) ?? $this->config->getByType($config);
    }
}
