<?php

namespace Tracker;

abstract class eventType
{
  const INCREMENTEVENT  = 1;
  const DECREMENTEVENT  = 2;
  const TIMINGEVENT     = 3;
}

class event
{
  private $eventName;
  private $eventType;
  private $eventData;

  public function __construct($eventName, $eventType, $eventData = null)
  {
    if(empty($eventName) || empty($eventType))
    {
      throw new \Exception('Invalid Argument');
    }

    $this->eventName = $eventName;
    $this->eventType = $eventType;
    $this->eventData = $eventData;
  }

  public function toJson()
  {
    $data = [
      'event_name' => $this->eventName,
      'event_type' => $this->eventType
    ] + ($this->eventData?['event_data' => $this->eventData]:[]);

    return json_encode($data);
  }
}

class Tracker extends eventType
{
  private $eventPool = [];

  private $handler = null;


  public function __construct($handler = null)
  {
    $this->handler = $handler;

    if(null === $handler)
    {
      $this->handler = new UdpHandler();
    }
  }

  public function increment($event_name = null)
  {
    if(empty($event_name))
    {
      return false;
    }

    $this->eventPool[] = new event($event_name, self::INCREMENTEVENT);

    return true;
  }

  public function decrement($event_name)
  {
    if(empty($event_name))
    {
      return false;
    }

    $this->eventPool[] = new event($event_name, self::DECREMENTEVENT);

    return true;
  }

  public function timing($event_name, $time)
  {
    if(empty($event_name) || !is_int($time))
    {
      return false;
    }

    $this->eventPool[] = new event($event_name, self::TIMINGEVENT, $time);

    return true;
  }

  public function send()
  {
    if(null === $this->handler)
    {
      return false;
    }

    if(count($this->eventPool) > 0)
    {
      foreach($this->eventPool as $event)
      {
        $this->handler->send($event->toJson());
      }
    }

    $this->eventPool = [];

    return true;
  }

}
