<?php declare(strict_types=1);

namespace VMPL\PopupManagement\Block\Widget;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Widget\Block\BlockInterface;
use VMPL\PopupManagement\Helper\Config;

class CmsPopup extends \Magento\Cms\Block\Widget\Block implements BlockInterface, IdentityInterface
{
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Cms\Model\Template\FilterProvider       $filterProvider,
        \Magento\Cms\Model\BlockFactory                  $blockFactory,
        protected readonly Config                        $config,
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
        $value = $this->getData($config->getFieldName());
        return $value === 'default' || empty($value)
            ? $this->config->getByType($config)
            : $value;
    }
}
