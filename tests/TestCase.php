<?php

namespace Tests;

use App\Kernel;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\RequestContext;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @param $exception
     * @return Kernel
     */
    protected function getFrameworkForException($exception): Kernel
    {

        $matcher = $this->createMock(UrlMatcherInterface::class);

        $matcher
            ->expects($this->once())
            ->method('match')
            ->will($this->throwException($exception))
        ;
        $matcher
            ->expects($this->once())
            ->method('getContext')
            ->will($this->returnValue($this->createMock(RequestContext::class)))
        ;
        $controllerResolver = $this->createMock(ControllerResolverInterface::class);
        $argumentResolver = $this->createMock(ArgumentResolverInterface::class);

        return new Kernel($matcher, $controllerResolver, $argumentResolver);
    }
}
