<?php
declare(strict_types=1);

namespace lib;

use Error;

function route(string $rpath, string $method): void
{
    try {

        // throw new Error();
        
        if ($rpath === '') {
            $rpath = 'home';
        }

        $targetFile = SOURCE_BASE . "/controllers/{$rpath}.php";

        if (!file_exists($targetFile)) {
            require_once SOURCE_BASE . '/views/404.php';
            return;
        }

        require_once $targetFile;

        // Use namespace (\<-escape)\{namespace}(\<-escape)\{$rpath}(\<-escape)\{$method}
        $fn = "\\controller\\{$rpath}\\{$method}";

        $fn();
    } catch (\Throwable $th) {
        Msg::push(Msg::DEBUG, $th->getMessage());
        Msg::push(Msg::ERROR, 'Oops, Something is wrong!');
        // redirect('404');
        require_once SOURCE_BASE . '/views/404.php';
    }
}
