<?php

declare(strict_types=1);

/**
 * Cli script to interact with the auction system.
 * This file is implemented as script to be executed from the command line.
 *
 * @author Maxim Antonisin <maxim.antonisin@gmail.com>
 *
 * @version 1.0.0
 */
require_once './autoload.php';

/** Initialize main class, run/execute and check for errors/exceptions. */
try {
    $main = new Main($argv);
    $main->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
