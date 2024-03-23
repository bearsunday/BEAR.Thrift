<?php

declare(strict_types=1);

namespace BEARSunday\Thrift;

use BEAR\Package\Module\Import\ImportApp;
use BEAR\Resource\Annotation\ImportAppConfig;
use BEAR\Resource\Module\SchemeCollectionProvider;
use BEAR\Resource\SchemeCollectionInterface;
use Ray\Di\AbstractModule;
use Ray\Di\Exception\NotFound;

/**
 *  Provides SchemeCollectionInterface and derived bindings
 *
 *  This class is responsible for importing scheme configurations for Thrift applications.
 *  It extends the AbstractModule class and implements the configure() method to configure bindings.
 *
 *  The following bindings are provided:
 *
 *  SchemeCollectionInterface
 *  SchemeCollectionInterface:original
 *  :ImportAppConfig
 */
final class ImportThriftAppModule extends AbstractModule
{
    /**
     * Import scheme config
     *
     * @var array<ImportApp>
     */
    private array $importApps = [];

    /** @param array<ImportApp>|array<ThriftApp> $importApps */
    public function __construct(array $importApps)
    {
        foreach ($importApps as $importApp) {
            // create import config
            $this->importApps[] = $importApp;
        }

        parent::__construct();
    }

    /**
     * {@inheritDoc}
     *
     * @throws NotFound
     */
    protected function configure(): void
    {
        $this->bind()->annotatedWith(ImportAppConfig::class)->toInstance($this->importApps);
        $this->bind(SchemeCollectionInterface::class)->annotatedWith('original')->toProvider(SchemeCollectionProvider::class);
        $this->bind(SchemeCollectionInterface::class)->toProvider(ImportSchemeCollectionProvider::class);
    }
}
