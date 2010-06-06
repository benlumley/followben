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
    <div class="overlay span-4">
      <div class="date content">
        <form action="" method="post">
          <input type="text" name="start_timestamp" class="from selector" value="<?php echo date('d/m') ?>"/>
          <span>to</span>
          <input type="text" name="end_timestamp" class="to selector" value="<?php echo date('d/m') ?>" disabled="disabled"/>
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
    <fb:comments numposts="20" width="310"></fb:comments>
  </div>

  <div class="clear"></div>

  <div class="span-18">
    <!--<iframe src="http://www.facebook.com/plugins/livefeed.php?app_id=255955255198&amp;width=230&amp;height=600&amp;xid" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:230px; height:600px;" allowTransparency="true"></iframe>-->
  </div>
  <div class="span-6 last">
    
  </div>

  <div class="clear"></div>

  <!--
    <object type="application/x-shockwave-flash" allowScriptAccess="always" height="230" width="150" align="middle" data="http://www.justgiving.com/widgets/jgwidget.swf" flashvars="EggId=2420906&IsMS=0"><param name="movie" value="http://www.justgiving.com/widgets/jgwidget.swf" /><param name="allowScriptAccess" value="always" /><param name="allowNetworking" value="all" /><param name="quality" value="high" /><param name="wmode" value="transparent" /><param name="flashvars" value="EggId=2420906&IsMS=0" /></object>
  -->
  <hr/>
  <div class="footer">
    Website by Ben Lumley and <a href="http://www.twitter.com/stevelacey">@stevelacey</a>
  </div>
</div>