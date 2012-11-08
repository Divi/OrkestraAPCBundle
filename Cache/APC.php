<?php

namespace Orkestra\APCBundle\Cache;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class APC
{
	const CACHE_INFO_TYPE_USER			= "user";
	const CACHE_INFO_TYPE_FILEHITS		= "filehits";
	const CACHE_INFO_TYPE_SYSTEM		= "system";
	const CACHE_INFO_TYPE_SYSTEM_FULL	= "system_full";

	/**
	 * @param string $name The param's name
	 * @param mixed $value The param's value
	 * @param int $timeout Timeout before auto deleting, in seconds
	 * @param boolean $override If true the previous value will overrided if already exists.
	 *
	 * @return boolean
	 */
	public function set($name, $value, $timeout = null, $override = true)
	{
		if ($override) {
			return apc_store($name, $value, $timeout);
		}
		else {
			return apc_add($name, $value, $timeout);
		}
	}

	/**
	 * @param string $name The param's name
	 *
	 * @return mixed
	 */
	public function get($name)
	{
		return apc_fetch($name);
	}

	/**
	 * @param string|array $name The param's name
	 *
	 * @return boolean True if the param is cached, false otherwise
	 */
	public function exist($name)
	{
		return apc_exists($name);
	}

	/**
	 * Delete a cached param
	 *
	 * @param string $name The param's name
	 */
	public function delete($name)
	{
		return apc_delete($name);
	}

	/**
	 * @param string $type The cache's type
	 *
	 * @return boolean
	 */
	public function info($type = null)
	{
		if ($type != null && $type != self::CACHE_INFO_TYPE_FILEHITS && $type != self::CACHE_INFO_TYPE_USER && type != self::CACHE_INFO_TYPE_SYSTEM) {
			throw new \InvalidArgumentException("Unknown cache's type for value : " . $type . " !");
		}

		switch ($type)
		{
			case self::CACHE_INFO_TYPE_SYSTEM:
				return apc_sma_info();
			case self::CACHE_INFO_TYPE_SYSTEM_FULL:
				return apc_sma_info(false);
		}

		return apc_cache_info($type);
	}

	/**
	 * Clear the APC cache
	 *
	 * @param boolean $onlyUsers If true, only users will be deleted, otherwise all cache will be deleted
	 *
	 * @return boolean
	 */
	public function clear($onlyUsers = false)
	{
		if (!$onlyUsers) {
			return apc_clear_cache();
		}
		else {
			return apc_clear_cache(self::CACHE_INFO_TYPE_USER);
		}
	}

	/**
	 * @param string $name The key
	 * @param int	 $step The value to increase
	 * @param null	 $success True if success, false otherwise
	 *
	 * @return int|boolean Return the value in case of success, false otherwise
	 */
	public function increment($name, $step = 1, &$success = null)
	{
		return apc_inc($name, $step, $success);
	}

	/**
	 * @param string $name The key
	 * @param int	 $step The value to decrease
	 * @param null	 $success True if success, false otherwise
	 *
	 * @return int|boolean Return the value in case of success, false otherwise
	 */
	public function decrement($name, $step = 1, &$success = null)
	{
		return apc_dec($name, $step, $success);
	}

	/**
	 * @return boolean True if APC is enabled, false otherwise
	 */
	public function isEnabled()
	{
		if (function_exists('apc_add')) {
			return true;
		}

		return false;
	}
}