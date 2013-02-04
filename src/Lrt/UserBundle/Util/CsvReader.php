<?php

namespace Lrt\UserBundle\Util;

class CsvReader
{
    protected $handle;
    protected $delimiter;
    protected $enclosure;
    protected $line;
    protected $headers;

    /*
     * Open CSV file
     *
     * @param $file
     * @param $mode
     * @param string $delimiter
     * @param string $enclosure
     * @param boolean $hasHeaders
     */

    public function open($file, $delimiter = ',', $mode = 'r+', $enclosure = '"', $hasHeaders = true)
    {
        $this->handle = fopen($file, $mode);
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
        $this->line = 0;

        if ($hasHeaders) {
            $this->headers = $this->formatHeaders($this->getRow());
        }
    }

    /*
     * Return a row
     */

    public function getRow()
    {
        if (($row = fgetcsv($this->handle, 1000, $this->delimiter, $this->enclosure)) !== false) {
            $this->line++;

            return $row;
        } else {
            return false;
        }
    }

    /*
     * Return entire table
     *
     * @return array results
     */

    public function getAll()
    {
        $data = array();
        while ($row = $this->getRow()) {
            $data[] = $row;
        }

        return $data;
    }

    /*
     * Get headers
     */

    public function getHeaders()
    {
        return $this->headers;
    }

    /*
     * Format header names
     *
     * @param $headerRow
     */

    public function formatHeaders($row)
    {
        $headers = array();
        foreach ($row as $k => $v) {
            $headers[] = $this->toCamelCase($v);
        }

        return $headers;
    }

    /**
     * Translates a string with underscores into camel case
     *
     * @param string $str String in underscore format
     * @return string $str translated into camel caps
     */
    public function toCamelCase($str)
    {
        $str = ucfirst($str);
        $func = create_function('$c', 'return strtoupper($c[1]);');

        return preg_replace_callback('/_([a-z])/', $func, $str);
    }

    /*
     * Get line
     */

    public function getLine()
    {
        return $this->line;
    }

    /*
     * Close file
     */

    public function __destruct()
    {
        if (is_resource($this->handle)) {
            fclose($this->handle);
        }
    }
}
