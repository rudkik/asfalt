<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
    'default' => array
    (
        'type'       => 'PostgreSQL',
        'connection' => array(
            /**
             * There are two ways to define a connection for PostgreSQL:
             *
             * 1. Full connection string passed directly to pg_connect()
             *
             * string   info
             *
             * 2. Connection parameters:
             *
             * string   hostname    NULL to use default domain socket
             * integer  port        NULL to use the default port
             * string   username
             * string   password
             * string   database
             * boolean  persistent
             * mixed    ssl         TRUE to require, FALSE to disable, or 'prefer' to negotiate
             *
             * @link http://www.postgresql.org/docs/current/static/libpq-connect.html
             */

            'hostname'   => 'localhost',
            'username'   => 'postgres',
            'password'   => '12345!',
            // Xz8l8f?6 - благотворительность
            'persistent' => FALSE,
            'database'   => 'ct',
            //'database'   => 'ab1',
            // 'database'   => 'tax', // askhat1601@gmail.com askhat1601
           // 'database'   => 'hotel_',
            //'database'   => 'sladushka',
            //'database'   => 'ads',
            //'database'   => 'pyramid',
            'database'   => 'ab1_new',
            //'database'   => 'magazine',
              //'database'   => 'nur',
           // 'database'   => 'ab1_new',
            //'database'   => 'calendar',
          //  'database'   => 'auto_part',
           // 'database'   => 'finance',
        ),
        'primary_key'  => '*',   // Column to return from INSERT queries, see #2188 and #2273
        'primary_key_several' => TRUE,
        'schema'       => '',
        'table_prefix' => '',
        'charset'      => 'utf8',
        'caching'      => FALSE,
    ),

    'oracle' => array
    (
        'type'          => 'Oracle',
        'connection' => array(
            'connection_string'   => 'localhost/XE',
            'username'   => 'system',
            'password'   => '12345',
        ),
        'charset'      => 'utf8',
        'caching'      => FALSE,
        'owner'        => 'SCALECONTROL_6_0',
        'tablespace_name' => '',
        'primary_key' => '',
    ),

    'default_' => array
    (
        'type'       => 'MySQL',
        'connection' => array(
            /**
             * The following options are available for MySQL:
             *
             * string   hostname     server hostname, or socket
             * string   database     database name
             * string   username     database username
             * string   password     database password
             * boolean  persistent   use persistent connections?
             * array    variables    system variables as "key => value" pairs
             *
             * Ports and sockets may be appended to the hostname.
             */
            'hostname'   => 'localhost',
            'database'   => 'p-15583_ct',
            'username'   => 'p-155_user_ct',
            'password'   => 'Cby9l4$9',
            'persistent' => FALSE,
        ),
        'table_prefix' => '',
        'charset'      => 'utf8',
        'caching'      => FALSE,
    ),

    'smmarket' => array
    (
        'type'       => 'PostgreSQL',
        'connection' => array(
            /**
             * There are two ways to define a connection for PostgreSQL:
             *
             * 1. Full connection string passed directly to pg_connect()
             *
             * string   info
             *
             * 2. Connection parameters:
             *
             * string   hostname    NULL to use default domain socket
             * integer  port        NULL to use the default port
             * string   username
             * string   password
             * string   database
             * boolean  persistent
             * mixed    ssl         TRUE to require, FALSE to disable, or 'prefer' to negotiate
             *
             * @link http://www.postgresql.org/docs/current/static/libpq-connect.html
             */

            'hostname'   => 'localhost',
            'username'   => 'postgres',
            'password'   => '12345!',
            // Xz8l8f?6 - благотворительность
            'persistent' => FALSE,
            'database'   => 'smmarke3_db',
        ),
        'primary_key'  => '*',   // Column to return from INSERT queries, see #2188 and #2273
        'primary_key_several' => TRUE,
        'schema'       => '',
        'table_prefix' => '',
        'charset'      => 'utf8',
        'caching'      => FALSE,
    ),
);
