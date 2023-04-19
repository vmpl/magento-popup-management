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
        protected readonly array $registeredHandles = [], // @todo use widget instance inorder to fetch it and display it
    ) {
    }

    public function execute()
    {
        // TODO: Implement execute() method.
    }
}
