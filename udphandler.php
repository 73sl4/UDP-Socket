<?php

namespace Tracker;

class UdpHandler
{
  private $stream = null;
  private $socket = null;
  private $host = null;
  private $port = null;

  public function __construct($host = '127.0.0.1' , $port = 1223)
  {
    $this->host = $host;
    $this->port = $port;
    $this->socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

    socket_set_option($this->socket, SOL_SOCKET, SO_SNDTIMEO, ["sec" => 1, "usec" => 0]);

    socket_set_nonblock($this->socket);

    if(!$this->socket)
    {
      throw new \Exception('Unable to open stream');
    }
  }

  public function send($data)
  {
    if(!$this->socket)
    {
      throw new \Exception('Stream not opened');
    }
    
    socket_sendto($this->socket, $data, strlen($data), 0, $this->host, $this->port);

    return true;
  }
}
