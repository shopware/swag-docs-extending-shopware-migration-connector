<?php
/**
 * (c) shopware AG <info@shopware.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SwagMigrationBundleApiExample\Service;

use SwagMigrationBundleApiExample\Repository\BundleRepository;
use SwagMigrationConnector\Repository\ApiRepositoryInterface;
use SwagMigrationConnector\Service\AbstractApiService;

class BundleService extends AbstractApiService
{
    /**
     * @var BundleRepository
     */
    private $bundleRepository;

    /**
     * @param ApiRepositoryInterface $bundleRepository
     */
    public function __construct(ApiRepositoryInterface $bundleRepository)
    {
        $this->bundleRepository = $bundleRepository;
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array
     */
    public function getBundles($offset = 0, $limit = 250)
    {
        $bundles = $this->bundleRepository->fetch($offset, $limit);
        $ids = array_column($bundles, 'bundles.id');
        $bundleProducts = $this->bundleRepository->fetchBundleProducts($ids);
        $bundles = $this->mapData($bundles, [], ['bundles']);

        foreach ($bundles as &$bundle) {
            if (isset($bundleProducts[$bundle['id']])) {
                $bundle['products'] = $bundleProducts[$bundle['id']];
            }
        }

        return $this->cleanupResultSet($bundles);
    }
}
