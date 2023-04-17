<?php declare(strict_types=1);

namespace VMPL\PopupManagement\Block\Widget;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Widget\Block\BlockInterface;
use VMPL\PopupManagement\Model\ConfigProvider;

/**
 * Block of the widget
 */
class CmsPopup extends \Magento\Cms\Block\Widget\Block implements BlockInterface, IdentityInterface
{
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Cms\Model\Template\FilterProvider       $filterProvider,
        \Magento\Cms\Model\BlockFactory                  $blockFactory,
        protected readonly ConfigProvider                $configProvider,
        array                                            $data = [],
    ) {
        parent::__construct(
            $context,
            $filterProvider,
            $blockFactory,
            $data
        );
    }

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
        return $this->getData($config->getFieldName()) ?? $this->configProvider->getByType($config);
    }
}
