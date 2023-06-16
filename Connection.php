<?php
  $Connect = pg_connect("postgres://elqsbidwsiupya:2da458472fd972629e029cea8357a3701c3d2cdfddfa2dd23e50867d1c37f09a@ec2-3-210-173-88.compute-1.amazonaws.com:5432/dd2vdl2so386dl");
  if (!$Connect) {
      die("Connection failed");
  }
