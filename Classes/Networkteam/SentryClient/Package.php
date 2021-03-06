<?php
namespace Networkteam\SentryClient;

use Neos\Flow\Package\Package as BasePackage;

class Package extends BasePackage {

	/**
	 * {@inheritdoc}
	 */
	public function boot(\Neos\Flow\Core\Bootstrap $bootstrap) {
		require_once(FLOW_PATH_PACKAGES . '/Libraries/sentry/sentry/lib/Raven/Autoloader.php');
		\Raven_Autoloader::register();

		$bootstrap->getSignalSlotDispatcher()->connect('Neos\Flow\Core\Booting\Sequence', 'afterInvokeStep', function($step, $runlevel) use($bootstrap) {
			if ($step->getIdentifier() === 'neos.flow:objectmanagement:runtime') {
				// This triggers the initializeObject method
				$bootstrap->getObjectManager()->get('Networkteam\SentryClient\ErrorHandler');
			}
		});
	}
}