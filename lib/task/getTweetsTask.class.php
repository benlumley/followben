<?php

class getTweetsTask extends sfBaseTask {
  protected function configure() {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
    ));

    $this->namespace        = 'twitter';
    $this->name             = 'get-tweets';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [get-tweets|INFO] task retrieves tweets for the given username and enriches results via the individual tweet API.
Call it with:

  [php symfony get-tweets|INFO]
EOF;

	 $this->new              = 0;
	 $this->updated          = 0;
  }

  protected function execute($arguments = array(), $options = array()) {
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    
    $web = new sfWebBrowser();
    
    $this->logSection($this->namespace, 'Getting latest tweets for @'.sfConfig::get('app_twitter_username'));
    $atom = $web->get('http://search.twitter.com/search.atom?q=from:'.sfConfig::get('app_twitter_username').'&rpp=5');

    try {
      if(!$atom->responseIsError()) {
        $feed = new SimpleXMLElement($atom->getResponseText());

        foreach($feed->entry as $rss) {
          $id = preg_replace('/[^0-9]+/', '', $rss->link[0]['href']);
          $tweet = Doctrine::getTable('Tweet')->find($id);

          $namespaces = $rss->getNameSpaces(true);

          if($tweet instanceOf Tweet) {
            if(strtotime($rss->updated) <= strtotime($tweet->getUpdatedAt())) {
              continue;
            } else {
              $this->updated++;
            }
          } else {
            $tweet = new Tweet;
            $this->new++;
          }

          $file = $web->get('http://api.twitter.com/1/statuses/show/'.$id.'.json');
          try {
            if(!$file->responseIsError()) {
              $json = json_decode($file->getResponseText());

              $tweet->setId($id);
              $tweet->setText($rss->title);
              $tweet->setHTML(html_entity_decode($rss->content));
              $tweet->setUri($rss->link[0]['href']);
              if(isset($json->in_reply_to_status_id)) {
                $tweet->setReplyId($json->in_reply_to_status_id);
              }
              if(isset($json->in_reply_to_user_id)) {
                $tweet->setReplyUserId($json->in_reply_to_user_id);
                $tweet->setReplyUsername($json->in_reply_to_screen_name);
              }
              $tweet->setLanguage($rss->children($namespaces['twitter'])->lang);
              $tweet->setSource(html_entity_decode($rss->children($namespaces['twitter'])->source));
              $tweet->setCreatedAt($rss->published);
              $tweet->setUpdatedAt($rss->updated);

              $tweet->save();
              echo '.';
            } else {
              // Error response (eg. 404, 500, etc)
            }
          } catch (Exception $e) {
            // Adapter error (eg. Host not found)
          }
        }
      } else {
        // Error response (eg. 404, 500, etc)
      }
    } catch (Exception $e) {
      // Adapter error (eg. Host not found)
    }

    echo "\n";
    $this->logSection($this->namespace, 'Done: '.$this->new.' new, '.$this->updated.' updated.');
  }
}