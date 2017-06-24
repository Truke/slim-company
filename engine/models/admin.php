<?php

class Admin
{
    protected $_pdo;
    protected static $link = null;
    protected $perpage = 10;

    /**
     * Constructor
     */
    public function __construct($_pdo)
    {
        if (!is_null(self::$link))
            return self::$link;

        self::$link = $this;
        $this->_pdo = $_pdo;
    }

    /** Makes SET part of sql request. All data MUST be tested and prepared before!
     * @param $data array   array of values
     * @return string   SET part of SQL request
     */
    protected function pdoSet($data)
    {
        $res = [];
        foreach ($data as $name => $value) {
            if (is_numeric($value))
                $res[] = '`' . $name . '` = ' . $value;
            else if (is_bool($value))
                $res[] = '`' . $name . '` = ' . ($value ? 'true' : 'false');
            else if (is_array($value))
                $res[] = '`' . $name . '` = ' . $this->_pdo->quote(serialize($value));
            else // string
                $res[] = '`' . $name . '` = ' . $this->_pdo->quote($value);
        }
        return implode(', ', $res);
    }


    protected function calcPages($current, $count)
    {
        $max_page = ceil($count / $this->perpage) - 1;
        if ($current < 0)
            $current = 0;
        elseif ($current > $max_page)
            $current = $max_page;
        $pages = [];

        if ($max_page > 0)
            for ($i = 0; $i <= $max_page; $i++)
                $pages[$i] = $i + 1;

        return [
            'pages' => $pages,
            'current' => $current,
            'max' => $max_page,
            'count' => $count
        ];
    }
}