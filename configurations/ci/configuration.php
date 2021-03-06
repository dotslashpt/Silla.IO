<?php
/**
 * Continues Integration Configuration class.
 *
 * @package    Silla.IO
 * @subpackage Configurations\CI
 * @author     Plamen Nikolov <plamen@athlonsofia.com>
 * @copyright  Copyright (c) 2015, Silla.io
 * @license    http://opensource.org/licenses/GPL-3.0 GNU General Public License, version 3.0 (GPLv3)
 */

namespace Configurations\CI;

use Configurations;

/**
 * Configuration class implementation.
 */
class Configuration extends Configurations\Development\Configuration
{
    /**
     * @var array $CACHE Cache related configuration options.
     *
     * @example adapter   Caching adapter name.
     * @example routes    Whether to cache Routing routes.
     * @example labels    Whether to cache Localisation labels.
     * @example db_schema Whether to cache Database Entity tables schemas.
     * @example database  Database cache adapter database schema.
     * @example redis     Redis cache adapter connection parameters.
     */
    public $CACHE = array(
        'adapter'   => 'FileSystem',
        'routes'    => false,
        'labels'    => false,
        'db_schema' => true,
        'database'  => array(
            'table_name' => 'cache',
            'fields'     => array(
                'cache_key',
                'value',
                'expire',
            ),
        ),
        'redis'     => array(
            'scheme'  => 'tcp',
            'host'    => 'localhost',
            'port'    => 6379,
            'timeout' => 5.0,
        ),
    );

    /**
     * @var     (int|string)[] $DB DSN (Data source name).
     *
     * @example adapter        Adapter type (pdo_mysql|mysql|sqllite).
     * @example host           Connection host name.
     * @example port           Connection host port.
     * @example user           User name.
     * @example password       Password phrase.
     * @example name           Database name.
     * @example tables_prefix  Storage tables prefix.
     * @example encryption_key Database encryption key.
     * @example crypt_vector   Initialization Vector value.
     */
    public $DB = array(
        'adapter'        => 'pdo_mysql',
        'host'           => 'mysql',
        'port'           => 3306,
        'user'           => 'root',
        'password'       => 'dbs1cret',
        'name'           => 'silla_io',
        'tables_prefix'  => '',
        'encryption_key' => '25c6c7ff35bd13b0ff9979b151f2136c',
        'crypt_vector'   => 'dasn312321nssa1k',
    );
}
