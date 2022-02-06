<?php


namespace Source\Core;

use \PDO;
use \PDOException;

/**
 * Class Connect
 * @package Source\Core
 */
class Connect
{
    private const OPTIONS = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", /*Tipo de charset do banco*/
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, /*Sempre que ocorrer um erro gerar uma exception (alerta ou nada)*/
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, /*Agora todos os fetch seram obj por padrão top p OBJ*/
        PDO::ATTR_CASE => PDO::CASE_NATURAL /*o nome da coluna vem igual ao do banco, mas poderia ser UPPEr ou LOWEr*/
    ];

    private static $instance; /*static para a instancia fica na class e n no obj */

    /**
     * @return PDO
     */
    public static function getInstance(): PDO /*static para a instancia fica na class e n no obj */
    {
        if (empty(self::$instance)) {
            try {
                self::$instance = new PDO(
                    "mysql:host=" . CONF_DB_HOST . ";dbname=" . CONF_DB_NAME,
                    CONF_DB_USER,
                    CONF_DB_PASS,
                    self::OPTIONS
                );
            } catch (PDOException $exception) {
                die("<h1>Opa deu merda no banco....</h1>");
            }
        }
        return self::$instance;
    } /*garantindo que exista apenas um conecxão com o banco por isso static*/


    /**
     * Connect constructor.
     */
    final private function __construct() /*evitando de criar outras instancias */
    {
    }

    /**
     * Connect clone.
     */
    final private function __clone() /*evitando de clonar outras instancias */
    {
        // TODO: Implement __clone() method.
    }
}