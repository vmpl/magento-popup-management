<?php declare(strict_types=1);

namespace VMPL\PopupManagement\Controller\Popup;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;

class Trigger implements HttpGetActionInterface
{
    public function __construct(
        protected readonly RequestInterface $request,
        protected readonly ResultFactory $resultFactory,
        protected readonly \VMPL\PopupManagement\Api\PopupManagerInterface $popupManager,
    ) {
    }

    public function execute()
    {
        $identifier = (string)$this->request->getParam('identifier');
        $resultLayout = $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);
        $resultRaw = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $layout = $resultLayout->getLayout();

        $this->popupManager->appendPopupByIdentifier($identifier, $layout);
        $resultRaw->setContents($layout->renderElement($identifier));
        return $resultRaw;
    }
}
