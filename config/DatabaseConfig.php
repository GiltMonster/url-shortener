<?php 
namespace config;
require_once __DIR__ . '/../vendor/autoload.php';

use PDO;
use PDOException;
use Dotenv\Dotenv;

class DatabaseConfig{
     private static $host;
    private static $port;
    private static $user;
    private static $password;
    private static $database;
    private static $initialized = false;

    public function __construct(){
        if (!self::$initialized) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
            $dotenv->load();

            self::$host = $_ENV['DB_HOST'] ?? 'localhost';
            self::$port = $_ENV['DB_PORT'] ?? '3306';
            self::$user = $_ENV['DB_USER'] ?? 'root';
            self::$password = $_ENV['DB_PASSWORD'] ?? 'rootroot';
            self::$database = $_ENV['DB_NAME'] ?? 'my_database';
            self::$initialized = true;
        }
    }

    private function initDb(){
        $dsn = "mysql:host=" . self::$host . ";port=" . self::$port . ";dbname=" . self::$database;
        try {
            $pdo = new PDO($dsn, self::$user, self::$password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo "Connection db failed: " . $e->getMessage();
            return null;
        }
    }

    public static function getConnection(){
        $db = new DatabaseConfig();
        return $db->initDb();
    }


}