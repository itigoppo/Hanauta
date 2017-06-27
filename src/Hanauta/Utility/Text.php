<?php
/**
 * Hanauta : Development Library
 *
 * @author Hisato Sakanoue <itigoppo+github@gmail.com>
 * @copyright Copyright(c) Hisato Sakanoue <itigoppo+github@gmail.com>
 * @since 2.0.0
 */

namespace Hanauta\Utility;


class Text
{
    /**
     * Generate a random UUID version 4
     *
     * @see http://php.net/manual/ja/function.uniqid.php
     * @return string RFC 4122 UUID
     */
    public static function uuid()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}
