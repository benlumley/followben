<div class="container ">
  <div class="span-12">
    <img src="images/logo.png" alt="Follow Ben">
  </div>
  <div class="span-12 last" id="justgiving">
    <a href= 'http://www.justgiving.com/ben-lumley' alt='JustGiving - Sponsor me!' target='_blank'> <img src='/images/justgiving.png' width='230' height='50'> </a>
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

  <hr>

  <div class="span-6 ">
    <iframe src="http://www.facebook.com/plugins/livefeed.php?app_id=255955255198&amp;width=230&amp;height=600&amp;xid" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:230px; height:600px;" allowTransparency="true"></iframe>
    <fb:comments numposts="20" width="230"></fb:comments>
  </div>
  <div id="map_canvas" class="span-18 last" style="height: 600px"></div>
  <div class="tweets span-18 last">
    <h3><a href="http://www.twitter.com/benlumley">Ben's Tweets!</a></h3>
    <ul>
      <?php foreach($tweets as $tweet) : ?>
        <li><?php echo $tweet->getRawValue()->getHTML() ?></li>
      <?php endforeach ?>
    </ul>
  </div>
  <div class="clear"></div>


<!--
  <object type="application/x-shockwave-flash" allowScriptAccess="always" height="230" width="150" align="middle" data="http://www.justgiving.com/widgets/jgwidget.swf" flashvars="EggId=2420906&IsMS=0"><param name="movie" value="http://www.justgiving.com/widgets/jgwidget.swf" /><param name="allowScriptAccess" value="always" /><param name="allowNetworking" value="all" /><param name="quality" value="high" /><param name="wmode" value="transparent" /><param name="flashvars" value="EggId=2420906&IsMS=0" /></object>
-->
</div>