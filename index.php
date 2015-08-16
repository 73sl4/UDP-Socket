<?php
  namespace Tracker;
  include('./udphandler.php');
  include('./tracker.php');

  $tracker = new Tracker;

  $start = microtime(true);


  for($i = 0 ; $i < 1000000; $i++)
  {
    $tracker->increment('check'.$i);
    $tracker->decrement('check'.$i);
    $tracker->timing('check'.$i, time());

    $tracker->send();
  }

  $end = microtime(true);

  echo "Total time taken: " . ($end - $start);
