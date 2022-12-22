<?php

namespace WPGDPRC\Utils;

use DateTime;
use WPGDPRC\WordPress\Plugin;
use WPGDPRC\WordPress\Settings;

abstract class UserTypeHelper
{

    const private = 'private';
    const business = 'business';

    const user_type_option = Plugin::PREFIX . '_user_type';
    const last_shown_option = Plugin::PREFIX . '_last_shown';

    /**
     * Validate user type value.
     *
     * @param $value
     * @return bool
     */
    public static function isValid($value): bool
    {
        return in_array($value, [self::private, self::business]);
    }

    /**
     * Get the current user type.
     * @return string
     */
    public static function getUserType(): string
    {
        return get_option(self::user_type_option);
    }

    /**
     * Validate new user type.
     *
     * @param $value
     * @return bool
     */
    public static function setUserType($value): bool
    {
        if (!self::isValid($value)) {
            return false;
        }

        update_option(self::user_type_option, $value);
        return true;
    }

    /**
     * Get the modal day of month or false as default.
     * @return mixed
     */
    public static function getLastShown()
    {
        return get_option(self::last_shown_option, false);
    }

    /**
     * Set the modal day of month
     * @return mixed
     */
    public static function setLastShown($value)
    {
        return update_option(self::last_shown_option, $value);
    }

    /**
     * Determine whether to show the modal (again)
     *
     * @return false
     */
    public static function showModal()
    {
        if (self::getUserType() === self::private) {
            return false;
        }

        if (Settings::isPremium()) {
            return false;
        }

        $date = self::getLastShown();
        if ($date === false) {
            return false;
        }

        try {
            $date = (new DateTime())->setTimestamp($date);
            $now = new DateTime();

            if($date->diff($now)->days > 1) {
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }
}
