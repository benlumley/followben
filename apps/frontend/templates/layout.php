<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <script src="http://maps.google.com/maps?file=api&v=2&key=<?php echo sfConfig::get('app_google_maps_api_key') ?>&sensor=false"
        type="text/javascript">
    </script>
  </head>
  <body>
    <?php echo $sf_content ?>
    <div id="fb-root"></div>
  </body>
</html>




