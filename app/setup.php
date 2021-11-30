<?php

require_once 'utils.php';

// load models
require_once_all(app_dir() . 'model/');
// load controllers
require_once_all(app_dir() . 'controllers/');

// load configs
require_once 'config.php';

if (array_key_exists('controller', $_POST)) {
    // call handlers of suitable controllers
    $controllerId = urldecode($_POST['controller']);

    foreach ($config['controllers'] as $controller) {
        if ($controllerId == $controller->getId()) {
            // pull only required elements from POST
            $extracted = extract_from($_POST, $controller->getKeys());
            // decode if necessary
            $extracted = array_map(fn(string $value): string => urldecode($value), $extracted);
            // suitable controller found -> call with requested keys
            $controller->handle($extracted);
        }
    }
}
