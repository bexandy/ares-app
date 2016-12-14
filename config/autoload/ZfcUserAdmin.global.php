<?php
/**
 * ZfcUserAdmin Configuration
 *
 * If you have a ./config/autoload/ directory set up for your project, you can
 * drop this config file in it and change the values as you wish.
 */
$settings = array(
    'user_mapper' => 'ZfcUserAdmin\Mapper\UserZendDb',
    'create_user_auto_password' => false,

);

/**
 * You do not need to edit below this line
 */
return array(
    'zfcuseradmin' => $settings
);
