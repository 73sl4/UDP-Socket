<?php
  namespace Tracker;
  include('./udphandler.php');
  include('./tracker.php');

  try
  {
    $tracker = new Tracker;
  }
  catch (\Exception $e)
  {
    exit(0);
  }

  $start = microtime(true);

  for($i = 0 ; $i < 1000000; $i++)
  {
    $tracker->increment('check'.$i);
    $tracker->decrement('check'.$i);
    $tracker->timing('check'.$i, time());

    try
    {
      $tracker->send();
    }
    catch (\Exception $e)
    {
      echo "Exception Occurred";
    }
  }

  $end = microtime(true);

  echo "Total time taken: " . ($end - $start);
