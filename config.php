<?php
declare(strict_types=1);

/**
 * Basit PDO bağlantısı sağlayan yapılandırma dosyası.
 * Ortam değişkenleri üzerinden veritabanı bağlantı bilgilerini
 * özelleştirebilirsiniz. Örneğin:
 *   export APP_DB_HOST=localhost
 *   export APP_DB_NAME=academic_profile
 *   export APP_DB_USER=root
 *   export APP_DB_PASS=secret
 */

function env_or_default(string $key, string $default): string
{
    $value = getenv($key);
    if ($value === false || $value === '') {
        return $default;
    }

    return $value;
}

define('APP_DB_HOST', env_or_default('APP_DB_HOST', '127.0.0.1'));
define('APP_DB_PORT', env_or_default('APP_DB_PORT', '3306'));
define('APP_DB_NAME', env_or_default('APP_DB_NAME', 'academic_profile'));
define('APP_DB_USER', env_or_default('APP_DB_USER', 'root'));
define('APP_DB_PASS', env_or_default('APP_DB_PASS', ''));

/**
 * Tekil PDO örneği döndürür.
 *
 * @throws PDOException bağlanılamadığı durumlarda
 */
function getPDO(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
        APP_DB_HOST,
        APP_DB_PORT,
        APP_DB_NAME
    );

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $pdo = new PDO($dsn, APP_DB_USER, APP_DB_PASS, $options);

    return $pdo;
}
