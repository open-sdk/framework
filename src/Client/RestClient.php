<?php

namespace OpenSdk\Framework\Client;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

abstract class RestClient extends Client
{
	/**
	 * Create a new request instance, using a required method and URI and extra options.
	 *
	 * @param string              $method
	 * @param UriInterface|string $uri
	 * @param array               $options
	 *
	 * @return RequestInterface
	 */
	public function createRequest(string $method, $uri, array $options = [])
	{
		$factory = $this->getHttpFactory();

		$headers = $options['headers'] ?? [];
		$body = $options['body'] ?? null;
		$version = $options['protocol'] ?? '1.1';

		return $factory->createRequest($method, $uri, $headers, $body, $version);
	}

	/**
	 * Perform a GET request, created using the URI and options.
	 *
	 * @see self::send()
	 *
	 * @param string|UriInterface $uri
	 * @param array               $options
	 *
	 * @return mixed
	 */
	public function get($uri, array $options = [])
	{
		return $this->send(
			$this->createRequest('GET', $uri, $options)
		);
	}

	/**
	 * Perform a POST request, created using the URI and options.
	 *
	 * @see self::send()
	 *
	 * @param string|UriInterface $uri
	 * @param array               $options
	 *
	 * @return mixed
	 */
	public function post($uri, array $options = [])
	{
		return $this->send(
			$this->createRequest('POST', $uri, $options)
		);
	}

	/**
	 * Perform a PUT request, created using the URI and options.
	 *
	 * @see self::send()
	 *
	 * @param string|UriInterface $uri
	 * @param array               $options
	 *
	 * @return mixed
	 */
	public function put($uri, array $options = [])
	{
		return $this->send(
			$this->createRequest('PUT', $uri, $options)
		);
	}

	/**
	 * Perform a PATCH request, created using the URI and options.
	 *
	 * @see self::send()
	 *
	 * @param string|UriInterface $uri
	 * @param array               $options
	 *
	 * @return mixed
	 */
	public function patch($uri, array $options = [])
	{
		return $this->send(
			$this->createRequest('PATCH', $uri, $options)
		);
	}

	/**
	 * Perform a DELETE request, created using the URI and options.
	 *
	 * @see self::send()
	 *
	 * @param string|UriInterface $uri
	 * @param array               $options
	 *
	 * @return mixed
	 */
	public function delete($uri, array $options = [])
	{
		return $this->send(
			$this->createRequest('DELETE', $uri, $options)
		);
	}
}
