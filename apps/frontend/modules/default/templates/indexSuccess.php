<div class="container">
  <div class="span-12">
    <a href="/"><img src="images/logo.png" alt="Follow Ben"/></a>
  </div>
  <div class="span-12 last" id="justgiving">
    <a href="http://www.justgiving.com/ben-lumley" title="JustGiving - Sponsor me!" target="_blank">
      <img src="/images/justgiving.png" width="230" height="50" alt="JustGiving - Sponsor me!"/>
    </a>
  </div>
  <div class="clear"></div>

  <div class="span-6 blob">
    <h2>What Am I Doing?</h2>
    <p>I am cycling from Lands End to John O'Groats in aid of Friends of Bristol Haematology and Oncology Centre</p>
  </div>
  <div class="span-6 blob">
    <h2>What's this?</h2>
    <p>Its a map that will show.</p>
  </div>
  <div class="span-6 blob">
    <h2>Follow Me</h2>
    <p>I am cycling from Lands End to John O'Groats in aid of the Friends of Bristol Haematology and Oncology Centre at the BRI in Bristol</p>
    <p>This map will let you keep an eye on my progress, whilst subtly convincing you to sponsor me!</p>
  </div>
  <div class="span-6 blob last">
    <h2>Sponsor Me</h2>
    <p>I am cycling from Lands End to John O'Groats in aid of the Friends of Bristol Haematology and Oncology Centre at the BRI in Bristol</p>
    <p>This map will let you keep an eye on my progress, whilst subtly convincing you to sponsor me!</p>
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
    <h3>The Latest ...</h3>
    <ul id="twitter">
      <?php foreach($tweets as $tweet) : ?>
        <li>
          <span class="tweet"><?php echo preg_replace('/<a[^>]+>#[^<]+<\/a>/', '', $tweet->getRawValue()->getHTML()) ?></span>
          <span class="time"><?php echo nice_time($tweet->getDateTimeObject('created_at')->format('U')) ?></span>
          <div class="clear"></div>
        </li>
      <?php endforeach ?>
    </ul>
    <h3>Post A Comment...</h3>
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