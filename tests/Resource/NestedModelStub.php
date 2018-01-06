<?php

namespace OpenSdk\Tests\Resource;

use OpenSdk\Resource\Model;

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
