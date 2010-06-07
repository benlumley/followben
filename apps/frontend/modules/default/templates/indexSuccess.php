<div class="container">
  <div class="span-12">
    <a href="/"><img src="images/logo.png" alt="Follow Ben"/></a>
  </div>
  <div class="span-12 last">
    <div id="fblike"><fb:like href="http://followben.co.uk" show_faces="false" width="470"></fb:like></div>
    <div id="justgiving">
      <a href="http://www.justgiving.com/ben-lumley" title="JustGiving - Sponsor me!" target="_blank">
        <img src="/images/justgiving.png" width="230" height="50" alt="JustGiving - Sponsor me!"/>
      </a>
    </div>
  </div>
  <div class="clear"></div>

  <div class="span-6 blob">
    <h2>You can follow me</h2>
    <p>Keep an eye on the map below and you can follow me on my cycle ride from Lands End to John O'Groats. I'm off early on Friday morning, and cycling around 100 miles a day, plan to reach John O'Groats the following Saturday.</p>
  </div>
  <div class="span-6 blob">
    <h2>You can support me</h2>
    <p>It's not going to be easy - and I'm going to need your support. In between Mars bars and Lucozades I'll be sending you the latest news (look out for updates in the box to the right of the map) - so please humour me, and post your comments of encouragement!</p>
  </div>
  <div class="span-6 blob">
    <h2>You can ask why</h2>
    <p>I'm not doing this just to prove my masculinity (or to keep Travelodge in business), but to raise money for the Friends of Bristol Haematology and Oncology Centre. They do fantastic work - including funding research, equipment and projects that improve the comfort of cancer patients undergoing treatment.</p>
     </div>
  <div class="span-6 blob last">
    <h2>You can sponsor me</h2>
    <p>A huge thank you to everyone who has already kindly sponsored me. But the more the merrier. You can donate online at justgiving - and as I'm funding all of the trip myself, all donations will go straight to the Friends group.</p>
  </div>

  <hr/>

  <div class="map span-16">
    <div id="canvas">
      Map Loading...
    </div>
    <div class="overlay">
      <div class="date content">
        <form action="" method="post">
          <span>From</span>
          <input type="text" name="start_timestamp" class="from selector" value="<?php echo date('D d M') ?>"/>
          <span>to</span>
          <input type="text" name="end_timestamp" class="to selector" value="<?php echo date('D d M') ?>" disabled="disabled"/>
          <input type="hidden" name="real_start_timestamp" id="real_start_timestamp" value="<?php echo date('d/m') ?>">
          <input type="hidden" name="real_end_timestamp" id="real_end_timestamp" value="<?php echo date('d/m') ?>">
        </form>
      </div>
    </div>
  </div>

  <div class="tweets span-8 last">
    <h3>News from the road...</h3>
    <ul id="twitter">
      <?php foreach($tweets as $tweet) : ?>
        <li>
          <span class="tweet"><?php echo preg_replace('/<a[^>]+>#[^<]+<\/a>/', '', $tweet->getRawValue()->getHTML()) ?></span>
          <span class="time"><?php echo nice_time($tweet->getDateTimeObject('created_at')->format('U')) ?></span>
          <div class="clear"></div>
        </li>
      <?php endforeach ?>
    </ul>
    <h3>Post a comment...</h3>
    <fb:comments xid="followben" numposts="20" width="310" url="http://followben.co.uk/" css="http://followben.co.uk/css/fbcomments.css?1=2"></fb:comments>
  </div>

  <div class="clear"></div>

  <hr/>
  <div class="footer">
    Website by Ben Lumley and <a href="http://www.twitter.com/stevelacey" target="_blank">@stevelacey</a> | Design by <a href="http://flatelephantdesign.com/" target="_blank">Flat Elephant Design</a>
  </div>
</div>