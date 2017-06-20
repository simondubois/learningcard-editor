#!/usr/bin/env php
<?php

ini_set('memory_limit', '-1');

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Simondubois\LearningCardEditor\Command;

$application = new Application();

$application->add(new Command());

$application->run();
