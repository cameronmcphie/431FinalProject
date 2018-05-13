<?php
  function do_header($title) {
?>
    <!doctype html>
    <html>
      <head>
        <meta charset="utf-8">
        <title>
          <?php echo $title;?>
        </title>
        <link rel="stylesheet" href="styles.css">
      </head>
    <body>

<?php
  }

  function do_footer() {
?>
    </body>
  </html>
<?php
  }
?>
