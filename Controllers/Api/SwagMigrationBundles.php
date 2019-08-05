<?php
/**
 * (c) shopware AG <info@shopware.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use SwagMigrationBundleApiExample\Service\BundleService;
use SwagMigrationConnector\Service\ControllerReturnStruct;

class Shopware_Controllers_Api_SwagMigrationBundles extends Shopware_Controllers_Api_Rest
{
    public function indexAction()
    {
        $offset = (int) $this->Request()->getParam('offset', 0);
        $limit = (int) $this->Request()->getParam('limit', 250);

        /** @var BundleService $bundleService */
        $bundleService = $this->container->get('swag_migration_bundle_api_example.bundle_service');

        $bundles = $bundleService->getBundles($offset, $limit);
        $response = new ControllerReturnStruct($bundles, empty($bundles));

        $this->view->assign($response->jsonSerialize());
    }
}