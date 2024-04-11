<?php

class Popup{
  public string $type = "info"; 
  public string $msg;
  public string $onCloseRedirect;
  public int $timeout = 5000; // in milliseconds
}
$_Popup = new Popup;

