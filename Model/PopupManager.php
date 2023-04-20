<?php declare(strict_types=1);

namespace VMPL\PopupManagement\Model;

use Magento\Framework\View\LayoutInterface;
use Magento\Widget\Model\Widget\Instance as WidgetInstance;
use VMPL\PopupManagement\Api\PopupManagerInterface;

class PopupManager implements PopupManagerInterface
{
    public function __construct(
        protected readonly \Magento\Widget\Model\ResourceModel\Widget\Instance\CollectionFactory $collectionFactory,
    ) {
    }

    public function appendPopupByIdentifier(string $identifier, LayoutInterface $layout): void
    {
        $widgetInstance = $this->getWidgetInstanceByIdentifier($identifier);
        if (empty($widgetInstance)) {
            return;
        }

        $block = $layout->createBlock(
            \VMPL\PopupManagement\Block\Widget\CmsPopup::class,
            $identifier,
            ['data' => $widgetInstance->getWidgetParameters()]
        );
        $block->setTemplate(@$widgetInstance->getWidgetParameters()['template_on_demand']
            ?? 'VMPL_PopupManagement::widget/popup/default.phtml');
    }

    public function getWidgetInstanceByIdentifier(string $identifier): ?WidgetInstance
    {
        /** @var \Magento\Widget\Model\ResourceModel\Widget\Instance\Collection $collection */
        $collection = $this->collectionFactory->create();
        $select = $collection->getConnection()->select();
        $select->from(
            $collection->getResource()->getMainTable(),
            ['instance_id', 'identifier' => new \Zend_Db_Expr("json_unquote(json_extract(widget_parameters, '$.identifier_on_demand'))")]
        );
        $select->having('identifier = ?', $identifier);
        $instanceId = $collection->getConnection()->fetchOne($select);
        if (empty($instanceId)) {
            return null;
        }

        $collection->addFieldToFilter('instance_id', ['eq' => $instanceId]);
        $collection->setPageSize(1);
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $collection->fetchItem();
    }
}
