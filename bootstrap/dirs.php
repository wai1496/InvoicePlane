<?php
/**
 * InvoicePlane
 *
 * @package      InvoicePlane
 * @author       InvoicePlane Developers & Contributors
 * @copyright    Copyright (c) 2012 - 2018, InvoicePlane (https://invoiceplane.com/)
 * @license      http://opensource.org/licenses/MIT     MIT License
 * @link         https://invoiceplane.com
 */

/*
 * ---------------------------------------------------------------
 * SYSTEM DIRECTORY NAME
 * ---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" directory.
 * Set the path if it is not in the same directory as this file.
 */
$system_path = '../vendor/codeigniter/framework/system';

/*
 * ---------------------------------------------------------------
 * APPLICATION DIRECTORY NAME
 * ---------------------------------------------------------------
 *
 * If you want this front controller to use a different "application"
 * directory than the default one you can set its name here. The directory
 * can also be renamed or relocated anywhere on your server. If you do,
 * use an absolute (full) server path.
 * For more info please see the user guide:
 *
 * https://codeigniter.com/user_guide/general/managing_apps.html
 *
 * NO TRAILING SLASH!
 */
$application_folder = '../application';

/*
 * ---------------------------------------------------------------
 * VIEW DIRECTORY NAME
 * ---------------------------------------------------------------
 *
 * If you want to move the view directory out of the application
 * directory, set the path to it here. The directory can be renamed
 * and relocated anywhere on your server. If blank, it will default
 * to the standard location inside your application directory.
 * If you do move this, use an absolute (full) server path.
 *
 * NO TRAILING SLASH!
 */
$view_folder = '';

/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
 */

// Set the current directory correctly for CLI requests
if (defined('STDIN')) {
    chdir(dirname(__FILE__));
}

if (($_temp = realpath($system_path)) !== false) {
    $system_path = $_temp . DIRECTORY_SEPARATOR;
} else {
    // Ensure there's a trailing slash
    $system_path = strtr(
            rtrim($system_path, '/\\'),
            '/\\',
            DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
        ) . DIRECTORY_SEPARATOR;
}

// Is the system path correct?
if (!is_dir($system_path)) {
    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    $syspath = pathinfo(__FILE__, PATHINFO_BASENAME);
    echo 'Your system folder path is not set correctly. Please open the following file and correct this: ' . $syspath;
    exit(3); // EXIT_CONFIG
}

/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */
// The name of THIS file
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

// Path to the system directory
define('BASEPATH', $system_path);

// Path to the front controller (this file) directory
define('FCPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);

// Path to the front controller (this file) directory
define('IPPATH', FCPATH . '..' . DIRECTORY_SEPARATOR);

// Name of the "system" directory
define('SYSDIR', basename(BASEPATH));

// The path to the "application" directory
if (is_dir($application_folder)) {
    if (($_temp = realpath($application_folder)) !== false) {
        $application_folder = $_temp;
    } else {
        $application_folder = strtr(
            rtrim($application_folder, '/\\'),
            '/\\',
            DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
        );
    }
} elseif (is_dir(BASEPATH . $application_folder . DIRECTORY_SEPARATOR)) {
    $application_folder = BASEPATH . strtr(
            trim($application_folder, '/\\'),
            '/\\',
            DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
        );
} else {
    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo 'Your application folder path is not set correctly. Please open the following file and correct this: ' . SELF;
    exit(3); // EXIT_CONFIG
}

define('APPPATH', $application_folder . DIRECTORY_SEPARATOR);

// The path to the "views" directory
if (!isset($view_folder[0]) && is_dir(APPPATH . 'views' . DIRECTORY_SEPARATOR)) {
    $view_folder = APPPATH . 'views';
} elseif (is_dir($view_folder)) {
    if (($_temp = realpath($view_folder)) !== false) {
        $view_folder = $_temp;
    } else {
        $view_folder = strtr(
            rtrim($view_folder, '/\\'),
            '/\\',
            DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
        );
    }
} elseif (is_dir(APPPATH . $view_folder . DIRECTORY_SEPARATOR)) {
    $view_folder = APPPATH . strtr(
            trim($view_folder, '/\\'),
            '/\\',
            DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
        );
} else {
    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo 'Your view folder path is not set correctly. Please open the following file and correct this: ' . SELF;
    exit(3); // EXIT_CONFIG
}

define('VIEWPATH', $view_folder . DIRECTORY_SEPARATOR);

/*
 * ---------------------------------------------------------------
 * Base Constants
 * ---------------------------------------------------------------
 * Set the basic constants needed for InvoicePlane
 */

// Set the environment
define('IP_ENV', env('APP_ENVIRONMENT', 'production'));
define('ENVIRONMENT', IP_ENV);

// Enable the debug mode if applicable
define('IP_DEBUG', env('ENABLE_DEBUG'));

// Location of the ipconfig file
define('IPCONFIG_FILE', IPPATH . 'ipconfig');

// Logs folder
define('LOGS_FOLDER', APPPATH . 'logs' . DIRECTORY_SEPARATOR);

// Uploads folders and folders for temporary files
define('UPLOADS_FOLDER', IPPATH . 'uploads' . DIRECTORY_SEPARATOR);
define('UPLOADS_ARCHIVE_FOLDER', UPLOADS_FOLDER . 'archive' . DIRECTORY_SEPARATOR);
define('UPLOADS_CFILES_FOLDER', UPLOADS_FOLDER . 'customer_files' . DIRECTORY_SEPARATOR);
define('UPLOADS_TEMP_FOLDER', UPLOADS_FOLDER . 'temp' . DIRECTORY_SEPARATOR);
define('UPLOADS_TEMP_MPDF_FOLDER', UPLOADS_TEMP_FOLDER . 'mpdf' . DIRECTORY_SEPARATOR);