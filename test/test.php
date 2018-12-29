<?php
require_once 'autoprefixer.php';

$autoprefixer = new Autoprefixer(file_get_contents('../../bootstrap-php.css'));
file_put_contents('prefixed-bootstrap.css', $autoprefixer->compile());

$css_parser = new Sabberworm\CSS\Parser(file_get_contents('C:\wamp64\www\scssphp\example\bootstrap-4.1.3\dist\css\bootstrap.css'));
file_put_contents('orignal-bootstrap.css', $css_parser->parse()->render(Sabberworm\CSS\OutputFormat::createPretty()));