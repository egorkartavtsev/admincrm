<<<<<<< Upstream, based on origin/master
<?php
namespace Cache;
class APC {
	private $expire;
	private $active = false;

	public function __construct($expire) {
		$this->expire = $expire;
		$this->active = function_exists('apc_cache_info') && ini_get('apc.enabled');
	}

	public function get($key) {
		return $this->active ? apc_fetch(CACHE_PREFIX . $key) : false;
	}

	public function set($key, $value) {
		return $this->active ? apc_store(CACHE_PREFIX . $key, $value, $this->expire) : false;
	}

	public function delete($key) {
		if (!$this->active) {
			return false;
		}
		
		$cache_info = apc_cache_info('user');
		$cache_list = $cache_info['cache_list'];
		foreach ($cache_list as $entry) {
			if (strpos($entry['info'], CACHE_PREFIX . $key) === 0) {
				apcu_delete($entry['info']);
			}
		}
	}
}
=======
<<<<<<< HEAD
<?php
namespace Cache;
class APC {
	private $expire;
	private $active = false;

	public function __construct($expire) {
		$this->expire = $expire;
		$this->active = function_exists('apc_cache_info') && ini_get('apc.enabled');
	}

	public function get($key) {
		return $this->active ? apc_fetch(CACHE_PREFIX . $key) : false;
	}

	public function set($key, $value) {
		return $this->active ? apc_store(CACHE_PREFIX . $key, $value, $this->expire) : false;
	}

	public function delete($key) {
		if (!$this->active) {
			return false;
		}
		
		$cache_info = apc_cache_info('user');
		$cache_list = $cache_info['cache_list'];
		foreach ($cache_list as $entry) {
			if (strpos($entry['info'], CACHE_PREFIX . $key) === 0) {
				apcu_delete($entry['info']);
			}
		}
	}
}
=======
<?php
namespace Cache;
class APC {
	private $expire;
	private $active = false;

	public function __construct($expire) {
		$this->expire = $expire;
		$this->active = function_exists('apc_cache_info') && ini_get('apc.enabled');
	}

	public function get($key) {
		return $this->active ? apc_fetch(CACHE_PREFIX . $key) : false;
	}

	public function set($key, $value) {
		return $this->active ? apc_store(CACHE_PREFIX . $key, $value, $this->expire) : false;
	}

	public function delete($key) {
		if (!$this->active) {
			return false;
		}
		
		$cache_info = apc_cache_info('user');
		$cache_list = $cache_info['cache_list'];
		foreach ($cache_list as $entry) {
			if (strpos($entry['info'], CACHE_PREFIX . $key) === 0) {
				apcu_delete($entry['info']);
			}
		}
	}
}
>>>>>>> origin/master
>>>>>>> 0ccdbb6 Фиксация 21,01,2019
