<?php
namespace App;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

class Kernel
{
    public function __construct(
        private UrlMatcherInterface $matcher,
        private ControllerResolverInterface $controllerResolver,
        private ArgumentResolverInterface $argumentResolver,
    ) {
    }

    public function handle(Request $request)
    {
        $this->matcher->getContext()->fromRequest($request);

        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));

            $controller = $this->controllerResolver->getController($request);
            $arguments = $this->argumentResolver->getArguments($request, $controller);

            return call_user_func_array($controller, $arguments);
        } catch (ResourceNotFoundException $exception) {
            return new JsonResponse([
                'success' => false,
                'data' => $exception->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            dd($exception);
            return new JsonResponse([
                'success' => false,
                'data' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
