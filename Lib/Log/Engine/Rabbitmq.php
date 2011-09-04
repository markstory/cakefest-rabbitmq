<?php
App::uses('CakeLogInterface', 'Log');

class Rabbitmq implements CakeLogInterface {

	protected $_config = array(
		'host' => 'localhost',
		'port' => 5672,
		'user' => 'guest',
		'password' => 'guest',
		'vhost' => '/',
		'exchange' => 'cake_log',
		'exchangeType' => AMQP_EX_TYPE_DIRECT,
		'exchangeFlags' => 0,
		'types' => array('*')
	);

	protected $_connection;
	protected $_exchange;

	public function __construct($config) {
		$this->_config = array_merge($this->_config, $config);
		$this->createConnection();
	}

	public function createConnection() {
		$credentials = array(
			'host' => $this->_config['host'],
			'port' => $this->_config['port'],
			'vhost' => $this->_config['vhost'],
			'login' => $this->_config['user'],
			'password' => $this->_config['password'],
		);
		$this->_connection = new AMQPConnection($credentials);
	}

	public function connect() {
		$this->_connection->connect();
		$this->_exchange = new AMQPExchange($this->_connection);
		$this->_exchange->declare(
			$this->_config['exchange'],
			$this->_config['exchangeType'],
			$this->_config['exchangeFlags']
		);
	}

	public function write($type, $message) {
		if (!$this->_connection->isConnected()) {
			$this->connect();
		}
		if (!in_array($type, $this->_config['types']) && $this->_config['types'] !== array('*')) {
			return;
		}
		return $this->_exchange->publish($message, $type);
	}
}
