<?php

class Tweet extends BaseTweet {
  public function getHTMLHashtagsStripped() {
    return preg_replace('/<a[^>]+>#[^<]+<\/a>/', '', $this->getHTML());
  }
}