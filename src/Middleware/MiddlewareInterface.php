<?php

namespace OpenSdk\Framework\Middleware;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

interface MiddlewareInterface
{
    /**
     * Handle the outgoing request and return the response as the outcome.
     */
    public function __invoke(Request $request, Response $response, callable $next): Response;
}
