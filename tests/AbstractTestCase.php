<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests;

use Monolog\Formatter\LineFormatter;
use PHPUnit\Framework\TestCase;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;
use Target365\ApiSdk\ApiClient;

abstract class AbstractTestCase extends TestCase
{

    protected function getApiClient(): ApiClient
    {
        $secrets = new Secrets();

        $apiClient = new ApiClient(
            $secrets->getDomainUri(),
            $secrets->getAuthKeyName(),
            $secrets->getPrivateKey(),
            $this->getStdoutLogger()
        );

        return $apiClient;
    }


    /**
     * https://jtreminio.com/2013/03/unit-testing-tutorial-part-3-testing-protected-private-methods-coverage-reports-and-crap/
     *
     * Call protected/private method of a class.
     *
     * @param object $object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    protected function invokePrivateMethod($object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }


    /**
     * https://jtreminio.com/2013/03/unit-testing-tutorial-part-3-testing-protected-private-methods-coverage-reports-and-crap/
     *
     * Call protected/private method of a class.
     *
     * @param string $fqcn Class name
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    protected function invokePrivateStaticMethod(string $fqcn, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass($fqcn);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs(null, $parameters);
    }

    protected function getStdoutLogger(): LoggerInterface
    {
        $lineFormatter = new LineFormatter("%message%\n\n");

        $handler = new StreamHandler('php://stdout');
        $handler->setFormatter($lineFormatter);

        $logger = new Logger('name');
        $logger->pushHandler($handler);

        return $logger;
    }

}