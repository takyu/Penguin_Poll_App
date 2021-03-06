<?php
declare(strict_types=1);

namespace lib;

use model\AbstractModel;

class Msg extends AbstractModel
{
    protected static string|null $SESSION_NAME = '_msg';
    public const ERROR = 'error';
    public const INFO = 'info';
    public const DEBUG = 'debug';

    private static function init(): void
    {
        static::setSession([
            static::ERROR => [],
            static::INFO => [],
            static::DEBUG => [],
        ]);
    }

    public static function push(string $type, string $msg): void
    {
        // Initialize
        if (!is_array(static::getSession())) {
            static::init();
        }

        $msgs = static::getSession();
        $msgs[$type][] = $msg;
        static::setSession($msgs);
    }

    public static function flush(): void
    {
        try {
            $msgs_with_type = static::getSesssionAndFlush() ?? [];

            echo "<div id='messages'>";

            // Get array of type
            foreach ($msgs_with_type as $type => $msgs) {
                // Skip debug type messages if debug mode is disabled
                if ($type === static::DEBUG && !DEBUG) {
                    continue;
                }

                $color = set_class_alert($type);

                // Get the message in the array
                foreach ($msgs as $msg) {
                    echo "<div class='alert $color'>{$msg}</div>";
                }
            }

            echo '</div>';
        } catch (\Throwable $th) {
            Msg::push(Msg::DEBUG, $th->getMessage());
            Msg::push(Msg::DEBUG, 'error: in Msg::flush.');
        }
    }
}
