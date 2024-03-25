<?php

declare(strict_types=1);

namespace BEARSunday\Thrift;

use BEAR\Package\Module\Import\ImportApp;
use BEAR\Resource\Annotation\ImportAppConfig;
use BEAR\Resource\AppAdapter;
use BEAR\Resource\SchemeCollectionInterface;
use Ray\Di\Di\Named;
use Ray\Di\InjectorInterface;
use Ray\Di\ProviderInterface;

/** @implements ProviderInterface<SchemeCollectionInterface> */
final class ImportSchemeCollectionProvider implements ProviderInterface
{
    /** @param array<ImportApp>|array<ThriftApp> $importAppConfig */
    public function __construct(
        #[Named(ImportAppConfig::class)]
        private array $importAppConfig,
        #[Named('original')]
        private SchemeCollectionInterface $schemeCollection,
        private InjectorInterface $injector,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function get(): SchemeCollectionInterface
    {
        foreach ($this->importAppConfig as $app) {
            $adapter = $app instanceof ImportApp ? new AppAdapter($this->injector, $app->appName) :
                 new ThriftAdapter(new ResourceInvoke($app->thriftHost, $app->thriftPort));
            $this->schemeCollection
                ->scheme('page')->host($app->host)->toAdapter($adapter)
                ->scheme('app')->host($app->host)->toAdapter($adapter);
        }

        return $this->schemeCollection;
    }
}
