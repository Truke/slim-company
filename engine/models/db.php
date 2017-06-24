<?php

class db
{

    private static $_instance;
    private $_pdo;
    private static $_pdoUrl;
    private static $_pdoUser;
    private static $_pdoPassword;
    private static $_pdoPrm = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

    /**
     * Constructor
     */
    private function __construct()
    {
        $this->_pdo = new PDO(self::$_pdoUrl, self::$_pdoUser, self::$_pdoPassword, self::$_pdoPrm);
        $this->_pdo->setAttribute(PDO::ATTR_STATEMENT_CLASS, array("EPDOStatement\EPDOStatement", array($this->_pdo)));
    }

    /**
     * Get PDO instance
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    /**
     * Get connection
     */
    public function getConnection()
    {
        return $this->_pdo;
    }

    /** Set connection configuration
     * @param $pdoUrl       string
     * @param $pdoUser      string
     * @param $pdoPassword  string
     */
    public static function setConfig($pdoUrl, $pdoUser, $pdoPassword)
    {
        self::$_pdoUrl = $pdoUrl;
        self::$_pdoUser = $pdoUser;
        self::$_pdoPassword = $pdoPassword;
    }
}