<?php

namespace OpenSdk\Exception;

use OpenSdk\Resource\Factory;
use Throwable;

class ResourceException extends \RuntimeException implements SdkException
{
	/**
	 * The resource factory which caused this error.
	 *
	 * @var Factory
	 */
	private $factory;

	/**
	 * Create an error for issues during resource usage.
	 *
	 * @param Factory   $factory
	 * @param string    $message
	 * @param integer   $code
	 * @param Throwable $previous
	 */
	public function __construct(Factory $factory, string $message = '', int $code = 0, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);

		$this->factory = $factory;
	}

	/**
	 * Get the resource factory which caused the error.
	 *
	 * @return Factory
	 */
	public function getFactory(): Factory
	{
		return $this->factory;
	}
}
