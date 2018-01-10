<?php

namespace OpenSdk\Tests\Resource\Stubs;

use OpenSdk\Resource\Object\Model;

class UserModel extends Model
{
	/**
	 * Get the name of the user.
	 *
	 * @return string|null
	 */
	public function getName()
	{
		return $this->getAsString('name');
	}

	/**
	 * Get the exact birth date of the user.
	 *
	 * @return \DateTime|null
	 */
	public function getBirthdate()
	{
		return $this->getAsInstance(\DateTime::class, 'birthdate');
	}
}
