<?php
namespace App\tests\Feature;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class ExampleTest extends TestCase
{
    public function testNotFoundHandling()
    {

        $framework = $this->getFrameworkForException(new ResourceNotFoundException());

        $response = $framework->handle(new Request());
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}