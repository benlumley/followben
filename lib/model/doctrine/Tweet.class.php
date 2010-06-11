<?php

class Tweet extends BaseTweet {
  public function getHTMLHashtagsStripped() {
    return preg_replace('/<a[^>]+>#[^<]+<\/a>/', '', $this->getHTML());
    $msg = explode(" ", $msg);
    $lines = array();
    $line = 1;
    while (!empty($msg)) {
      $part = array_shift($msg);
      $out[$line] .= $part . ' ';
      if (strlen(strip_tags($out[$line]))>80) {
        $line++;
      }
    }
    return implode("<br />", $out);
  }
}