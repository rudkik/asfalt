<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_Memcache implements \SessionHandlerInterface {
    private $memcache;
    private $ttl;
    private $prefix;

    public function __construct(array $options = array() ) {
        $this->memcache = new Memcache();
        if ($diff = array_diff( array_keys( $options ), array( 'prefix', 'expiretime' ) ) ){
            throw new \InvalidArgumentException( sprintf('The following options are not supported "%s"',implode( ', ', $diff )));

        }
        $this->ttl    = isset( $options[ 'expiretime' ] ) ? (int)$options[ 'expiretime' ] : ini_get("session.gc_maxlifetime");
        $this->prefix = isset( $options[ 'prefix' ] ) ? $options[ 'prefix' ] : 'sf2s-';
    }

    public function open($save_path = '', $name = '') {
        $this->memcache->connect('127.0.0.1', 11211);
        return $this;
    }

    public function close() {
        $this->memcache->close();
        return $this;
    }
    public function read($key) {
        return $this->memcache->get( $this->prefix . $key ) ? : null;
    }

    public function write($key, $data ) {
        return $this->memcache->set( $this->prefix . $key, $data );
    }

    public function destroy( $sessionId ) {
        return $this->memcache->delete( $this->prefix . $sessionId );
    }

    public function gc( $lifetime ) {
        return true;
    }
}
?>