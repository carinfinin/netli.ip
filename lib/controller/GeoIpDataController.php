<?php
namespace Netli\Lib\Controller;
use Bitrix\Calendar\Core\Queue\Exception\Exception;
use Bitrix\Main\Engine\Controller;
use Netli\Lib\Factory\GeoIpProviderFactory;
use Netli\Lib\Service\GeoIpService;
use Netli\Lib\Service\GeoIpHLService;

class GeoIpDataController extends Controller
{
    private $logger;
    private $logName = "test.log";
    public function __construct()
    {
        parent::__construct();
        $this->logger = $this->getLogger($this->logName);
    }
    public function configureActions()
    {
        return [
            'getGeoIp' => [
                'prefilters' => []
            ],

        ];
    }
    public function getGeoIpAction($ip)
    {
        try {
            if (!filter_var($ip, FILTER_VALIDATE_IP)) {
                return [
                    'success' => false,
                    'error' => 'Not valid IP'
                ];
            }

            $hlService = new GeoIpHLService();
            $geoData = $hlService->getByIp($ip);

            if(!$geoData) {
                $httpClient = new \Bitrix\Main\Web\HttpClient();
                $providerFactory = new GeoIpProviderFactory($httpClient);
                $service = new GeoIpService($providerFactory, $this->logger);
                $geoData = $service->getGeoData($ip);
                $geoData['ip'] = $ip;

                if(!$hlService->save($geoData)) {
                    throw new \Exception('save error');
                }
            }

            return [
                'success' => true,
                'data' => $geoData
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    private function getLogger($logFile): \Psr\Log\LoggerInterface
    {
        $logger = new \Bitrix\Main\Diag\FileLogger($logFile);
        $logger->setLevel(\Psr\Log\LogLevel::ERROR);
        return $logger;
    }
}