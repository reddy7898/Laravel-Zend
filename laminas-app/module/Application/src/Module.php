<?php

declare(strict_types=1);

namespace Application;

class Module
{
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }

    public function getServiceConfig()
{
    return [
        'factories' => [
            Model\CustomerTable::class => function($container) {
                $tableGateway = $container->get(Model\CustomerTableGateway::class);
                return new Model\CustomerTable($tableGateway);
            },
            Model\CustomerTableGateway::class => function ($container) {
                $dbAdapter = $container->get(AdapterInterface::class);
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new Model\Customer());
                return new TableGateway('customers', $dbAdapter, null, $resultSetPrototype);
            },
        ],
    ];
}

}
