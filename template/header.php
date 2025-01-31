<?php

  # prevent direct access
  if (!defined("SYS11_SECRETS")) { die(""); }

  # prevents cache hits with wrong CSS
  $cache_value = md5_file(__FILE__);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title><?php print(htmlentities(SERVICE_TITLE)); ?></title>

    <link href="/vendors/bootstrap/css/bootstrap.min.css?<?php print($cache_value); ?>" integrity="sha256-916EbMg70RQy9LHiGkXzG8hSg9EdNy97GazNG/aiY1w=" rel="stylesheet" type="text/css" />

    <!--[if lt IE 9]>
      <script src="/vendors/html5shiv/html5shiv.min.js?<?php print($cache_value); ?>" integrity="sha256-3Jy/GbSLrg0o9y5Z5n1uw0qxZECH7C6OQpVBgNFYa0g=" type="text/javascript"></script>
      <script src="/vendors/respond/respond.min.js?<?php print($cache_value); ?>" integrity="sha256-ggacFe3WlD36pZ9aw/asyG/USij+kl5BDM3K3sGUqLo=" type="text/javascript"></script>
    <![endif]-->
  </head>

  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/"><?php print(htmlentities(SERVICE_TITLE)); ?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li<?php if (empty(SECRET_URI)) { ?> class="active"<?php } ?>><a href="/">Teile ein Geheimnis.</a></li>
            <li<?php if (0 === strcmp(SECRET_URI, HOW_PAGE_NAME)) { ?> class="active"<?php } ?>><a href="/how">Wir funktioniert dieser Dienst?</a></li>
            <li<?php if (0 === strcmp(SECRET_URI, IMPRINT_PAGE_NAME)) { ?> class="active"<?php } ?>><a href="/imprint">Wer steckt hinter diesem Dienst?</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="jumbotron text-center">
      <h1><?php print(htmlentities(PAGE_TITLE)); ?></h1>
      <p>Diese Seite erlaubt Ihnen ein Geheimnis oder einen geheimen Text über einen geheimen Link zu teilen.<br />
         Das Geheimnis selbst wird ausschließlich in der URL gespeichert und niemals auf unserem Server.<br />
         Ein geheimer Link kann nur einmalig verwendet werden.</p>
    </div>

    <div class="container">
      <!-- header -->
