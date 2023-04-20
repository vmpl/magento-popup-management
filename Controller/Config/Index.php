<?php declare(strict_types=1);

namespace VMPL\PopupManagement\Controller\Config;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use VMPL\PopupManagement\Model\ConfigProvider;
use VMPL\PopupManagement\Type\Config;

class Index implements HttpGetActionInterface
{
    public function __construct(
        protected readonly RequestInterface $request,
        protected readonly ResultFactory $resultFactory,
        protected readonly ConfigProvider $configProvider,
    ) {
    }

    protected final function getParamFilter(): array
    {
        $caseNames = Config::getCaseNames();
        $param = (array)$this->request->getParam('filter') ?? [];
        return array_filter($param, function ($caseName) use ($caseNames) {
            return in_array($caseName, $caseNames);
        });
    }

    public function execute()
    {
        $paramFilter = $this->getParamFilter();
        if (empty($paramFilter)) {
            $paramFilter = Config::getCaseNames();
        }

        $config = [];
        foreach ($paramFilter as $item) {
            $case = Config::class . "::" . $item;
            $case = constant($case);
            if (empty($case)) {
                continue;
            }

            /** @var Config $case */
            if (!$case->isStoreFrontAvalible()) {
                continue;
            }

            $config[$item] = $this->configProvider->getByType($case);
        }

        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($config);
        return $resultJson;
    }
}
