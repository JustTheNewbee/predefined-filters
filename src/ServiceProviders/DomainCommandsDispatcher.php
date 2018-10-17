<?php

namespace Polyloans\Filter\ServiceProviders;

use Illuminate\Database\Connection;
use Illuminate\Foundation\Application;

class DomainCommandsDispatcher
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * DomainCommandsDispatcher constructor.
     *
     * @param Application $app
     * @param Connection  $connection
     */
    public function __construct(Application $app, Connection $connection)
    {
        $this->app = $app;
        $this->сonnection = $connection;
    }

    /**
     * @param $eventName
     * @param $arg
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function handle($eventName, $arg)
    {
        $explodedNamespace = explode('\\', $eventName);
        $explodedNamespace[count($explodedNamespace) - 1] = 'Handler';

        $this->сonnection->beginTransaction();
        try {
            $result = ($this->app->make(implode('\\', $explodedNamespace)))->handle(reset($arg));
        } catch (\Exception $e) {
            $this->сonnection->rollback();

            throw $e;
        }
        $this->сonnection->commit();

        return $result;
    }
}
