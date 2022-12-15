<?php declare(strict_types=1);

namespace VMPL\PopupManagement\Block\Widget;

use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Model\Block as CmsBlock;
use Magento\Cms\Model\Template\FilterProvider;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template\Context;
use Magento\Widget\Block\BlockInterface;

class CmsPopup extends \Magento\Framework\View\Element\Template implements BlockInterface, IdentityInterface
{
    protected static $widgetUsageMap = [];
    protected ?CmsBlock $block = null;

    public function __construct(
        Context                                     $context,
        protected readonly FilterProvider           $filterProvider,
        protected readonly BlockRepositoryInterface $blockRepository,
        array                                       $data = []
    ) {
        parent::__construct($context, $data);
    }

    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();

        $blockId = $this->getData('block_id');
        $blockHash = get_class($this) . $blockId;

        if (isset(self::$widgetUsageMap[$blockHash])) {
            return $this;
        }
        self::$widgetUsageMap[$blockHash] = true;

        $block = $this->getBlock();

        if ($block && $block->isActive()) {
            try {
                $storeId = $this->getData('store_id') ?? $this->_storeManager->getStore()->getId();
                $this->setText(
                    $this->filterProvider->getBlockFilter()->setStoreId($storeId)->filter($block->getContent())
                );
            } catch (NoSuchEntityException $e) {
            }
        }
        unset(self::$widgetUsageMap[$blockHash]);
        return $this;
    }

    public function getIdentities()
    {
        $block = $this->getBlock();

        if ($block) {
            return $block->getIdentities();
        }

        return [];
    }

    private function getBlock(): ?CmsBlock
    {
        if (empty($this->block)) {
            if (($blockId = $this->getData('block_id'))) {
                try {
                    /** @var CmsBlock $block */
                    $block = $this->blockRepository->getById($blockId);
                    $stores = $block->getStores();
                    if ((isset($stores[0]) && $stores[0] == 0)
                        || in_array($this->_storeManager->getStore()->getId(), $stores)) {
                        $this->block = $block;
                    }
                } catch (NoSuchEntityException $e) {
                }
            }
        }

        return $this->block;
    }

    public function getGeneratedId(): string
    {
        $id = $this->getBlock()?->getId() ?? '';
        $id .= $this->getNameInLayout();
        return md5($id);
    }
}
