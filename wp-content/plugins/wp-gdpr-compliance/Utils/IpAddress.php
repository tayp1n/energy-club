<?php
namespace WPGDPRC\Utils;

/**
 * Class IpAddress
 * @package WPGDPRC\Utils
 */
class IpAddress {

    /**
     * Ensures an ip address is both a valid IP and does not fall within
     * a private network range.
     * @param string $ipAddress
     * @return bool
     */
    public static function validateIp( $ipAddress = '' ) {
        if( strtolower($ipAddress) === 'unknown' ) return false;

        // Generate ipv4 network address
        $ipAddress = ip2long($ipAddress);
        // If the ip is set and not equivalent to 255.255.255.255
        if( $ipAddress !== false && $ipAddress !== -1 ) {
            /**
             * Make sure to get unsigned long representation of ip
             * due to discrepancies between 32 and 64 bit OSes and
             * signed numbers (ints default to signed in PHP)
             */
            $ipAddress = sprintf('%u', $ipAddress);
            // Do private network range checking
            if( $ipAddress >= 0 && $ipAddress <= 50331647 ) return false;
            if( $ipAddress >= 167772160 && $ipAddress <= 184549375 ) return false;
            if( $ipAddress >= 2130706432 && $ipAddress <= 2147483647 ) return false;
            if( $ipAddress >= 2851995648 && $ipAddress <= 2852061183 ) return false;
            if( $ipAddress >= 2886729728 && $ipAddress <= 2887778303 ) return false;
            if( $ipAddress >= 3221225984 && $ipAddress <= 3221226239 ) return false;
            if( $ipAddress >= 3232235520 && $ipAddress <= 3232301055 ) return false;
            if( $ipAddress >= 4294967040 ) return false;
        }
        return true;
    }

    /**
     * @return string
     */
    public static function getClientIp() {
        // Check for shared internet/ISP IP
        if( !empty($_SERVER['HTTP_CLIENT_IP']) && self::validateIp($_SERVER['HTTP_CLIENT_IP']) ) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        // Check for IPs passing through proxies
        if( !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
            // Check if multiple ips exist in var
            if( strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false ) {
                $listOfIpAddresses = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach( $listOfIpAddresses as $ipAddress ) {
                    $ipAddress = trim($ipAddress);
                    if( self::validateIp($ipAddress) ) return $ipAddress;
                }
            } elseif( self::validateIp($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }

        if( !empty($_SERVER['HTTP_X_FORWARDED']) && self::validateIp($_SERVER['HTTP_X_FORWARDED']) ) {
            return $_SERVER['HTTP_X_FORWARDED'];
        }

        if( !empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && self::validateIp($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) ) {
            return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        }

        if( !empty($_SERVER['HTTP_FORWARDED_FOR']) && self::validateIp($_SERVER['HTTP_FORWARDED_FOR']) ) {
            return $_SERVER['HTTP_FORWARDED_FOR'];
        }

        if( !empty($_SERVER['HTTP_FORWARDED']) && self::validateIp($_SERVER['HTTP_FORWARDED']) ) {
            return $_SERVER['HTTP_FORWARDED'];
        }

        // Return unreliable ip since all else failed
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * @param string $ipAddress
     * @return bool
     */
    public static function checkIp( $ipAddress = '' ) {
        return self::getClientIp() === $ipAddress;
    }

}
