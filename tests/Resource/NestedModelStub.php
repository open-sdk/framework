<?php

namespace OpenSdk\Framework\Tests\Resource;

use OpenSdk\Framework\Resource\Model;

/**
 * @property string $nested
 */
class NestedModelStub extends Model
{
	/**
	 * {@inheritdoc}
	 */
	protected static $casts = [
		'nested' => 'string',
	];
}
