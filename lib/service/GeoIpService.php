<?php
namespace Netli\Lib\Service;

use Netli\Lib\Factory\GeoIpProviderFactory;
use Psr\Log\LoggerInterface;

class GeoIpService
{
    private $providerFactory;
    private $logger;
    public function __construct(GeoIpProviderFactory $providerFactory, LoggerInterface $logger = null)
    {
        $this->providerFactory = $providerFactory;
        $this->logger = $logger;
    }

    public function getGeoData(string $ip): array
    {
        foreach ($this->providerFactory->createAllProviders() as $provider) {
            try {
                $data = $provider->getGeoData($ip);
                if(!isset($data)) {
                    $this->logger->Debug("Provider {$provider->getName()} is not available");
                    continue;
                }
                return $provider->getGeoData($ip);
            } catch (\Exception $e) {
                $this->logger->Error("Provider {$provider->getName()} failed: " . $e->getMessage());
                continue;
            }
        }
        throw new \Exception('All GeoIP providers failed');
    }

}