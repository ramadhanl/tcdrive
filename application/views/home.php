<!DOCTYPE html>
<html lang="en">
  <head>
     <title>TC Drive</title>
  </head>
  <body>
  <div style="clear:both"></div>
  	<form role="form" method="POST" action="<?php  echo base_url(); ?>home/do_upload" enctype="multipart/form-data">
      <input name="userfile" type="file" />
      <input type="text" name="test">
      <input type="submit" value="upload" />
    </form>
  <div style="clear:both"></div>
  </body>
</html>
