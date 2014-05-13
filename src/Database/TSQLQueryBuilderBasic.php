<?php

namespace Anax\Database;

/**
 * Database wrapper, provides a database API for the framework but hides details of implementation.
 *
 */
trait TSQLQueryBuilderBasic
{

    /**
     * Properties
     */
    private $dialect;   // SQL dialect for a certain database
    private $sql;       // The query built
    private $prefix;    // Prefix to attach to all table names

    private $columns;   // Columns to select
    private $from;      // From part
    private $where;     // Where part
    private $orderby;   // Order by part



    /**
     * Get SQL.
     *
     * @return string as sql-query
     */
    public function getSQL()
    {
        if ($this->sql) {
            return $this->sql;
        } else {
            return $this->build();
        }
    }



    /**
     * Build SQL.
     *
     * @return string as SQL query
     */
    protected function build()
    {
        $sql = "SELECT\n\t"
            . $this->columns . "\n"
            . $this->from . "\n"
            . ($this->join    ? $this->join           : null)
            . ($this->where   ? $this->where . "\n"   : null)
            . ($this->orderby ? $this->orderby . "\n" : null)
            . ";";

        return $sql;
    }



    /**
     * Set database type to consider when generating SQL.
     *
     * @param string $dialect representing database type.
     *
     * @return void
     */
    public function setSQLDialect($dialect)
    {
        $this->dialect = $dialect;
    }



    /**
     * Set a table prefix.
     *
     * @param string $prefix to use in front of all tables.
     *
     * @return void
     */
    public function setTablePrefix($prefix)
    {
        $this->prefix = $prefix;
    }



    /**
     * Utilitie to check if array is associative array.
     *
     * http://stackoverflow.com/questions/173400/php-arrays-a-good-way-to-check-if-an-array-is-associative-or-sequential/4254008#4254008
     *
     * @param array $array input array to check.
     *
     * @return boolean true if array is associative array with at least one key, else false.
     *
     */
    private function isAssoc($array)
    {
        return (bool) count(array_filter(array_keys($array), 'is_string'));
    }



    /**
     * Create a table.
     *
     * @param string $name    the table name.
     * @param array  $columns the columns in the table.
     *
     * @return $this
     */
    public function createTable($name, $columns)
    {
        $cols = null;

        foreach ($columns as $col => $options) {
            $cols .= "\t" . $col . ' ' . implode(' ', $options) . ",\n";
        }
        $cols = substr($cols, 0, -2);

        $this->sql = "CREATE TABLE "
            . $this->prefix
            . $name
            . "\n(\n"
            . $cols
            . "\n);\n";

        if ($this->dialect == 'sqlite') {
            $this->sql = str_replace('auto_increment', '', $this->sql);
        }

        return $this;
    }



    /**
     * Drop a table.
     *
     * @param string $name the table name.
     *
     * @return $this
     */
    public function dropTable($name)
    {
        $this->sql = "DROP TABLE "
            . $this->prefix
            . $name
            . ";\n";

        return $this;
    }



    /**
     * Drop a table if it exists.
     *
     * @param string $name the table name.
     *
     * @return $this
     */
    public function dropTableIfExists($name)
    {
        $this->sql = "DROP TABLE IF EXISTS "
            . $this->prefix
            . $name
            . ";\n";

        return $this;
    }



    /**
     * Create a proper column value arrays from incoming $columns and $values.
     *
     * @param array  $columns 
     * @param array  $values
     *
     * @return list($columns, $values)
     */
    public function mapColumnsWithValues($columns, $values)
    {
        // If $values is null, then use $columns to build it up
        if (is_null($values)) {

            if ($this->isAssoc($columns)) {
    
                // Incoming is associative array, split it up in two
                $values = array_values($columns);
                $columns = array_keys($columns);
    
            } else {

                // Create an array of '?' to match number of columns
                for ($i = 0; $i < count($columns); $i++) {
                    $values[] = '?';
                }
            }
        }

        return [$columns, $values];
    }



    /**
     * Build a insert-query.
     *
     * @param string $name    the table name.
     * @param array  $columns to insert och key=>value with columns and values.
     * @param array  $values  to insert or empty if $columns has bot columns and values.
     *
     * @return void
     */
    public function insert($table, $columns, $values = null)
    {
        list($columns, $values) = $this->mapColumnsWithValues($columns, $values);

        if (count($columns) != count($values)) {
            throw new \Exception("Columns does not match values, not equal items.");
        }

        $cols = null;
        $vals = null;

        for ($i = 0; $i < count($columns); $i++) {
            $cols .= $columns[$i] . ', ';

            $val = $values[$i];

            if ($val == '?') {
                $vals .= $val . ', ';
            } else {
                $vals .= (is_string($val)
                    ? "'$val'"
                    : $val)
                    . ', ';
            }
        }

        $cols = substr($cols, 0, -2);
        $vals = substr($vals, 0, -2);

        $this->sql = "INSERT INTO "
            . $this->prefix
            . $table
            . "\n\t("
            . $cols
            . ")\n"
            . "\tVALUES\n\t("
            . $vals
            . ");\n";
    }



    /**
     * Build an update-query.
     *
     * @param string $name    the table name.
     * @param array  $columns to update or key=>value with columns and values.
     * @param array  $values  to update or empty if $columns has bot columns and values.
     * @param array  $where   limit which rows are updated.
     *
     * @return void
     */
    public function update($table, $columns, $values = null, $where = null)
    {
        // If $values is string, then move that to $where
        if (is_string($values)) {
            $where = $values;
            $values = null;
        }

        list($columns, $values) = $this->mapColumnsWithValues($columns, $values);

        if (count($columns) != count($values)) {
            throw new \Exception("Columns does not match values, not equal items.");
        }

        $cols = null;

        for ($i = 0; $i < count($columns); $i++) {
            $cols .= "\t" . $columns[$i] . ' = ';

            $val = $values[$i];
            if ($val == '?') {
                $cols .= $val . ",\n";
            } else {
                $cols .= (is_string($val)
                    ? "'$val'"
                    : $val)
                    . ",\n";
            }
        }

        $cols = substr($cols, 0, -2);

        $this->sql = "UPDATE "
            . $this->prefix
            . $table
            . "\nSET\n"
            . $cols
            . "\nWHERE "
            . $where
            . "\n;\n";
    }



    /**
     * Build a delete-query.
     *
     * @param string $name    the table name.
     * @param array  $where   limit which rows are updated.
     *
     * @return void
     */
    public function delete($table, $where = null)
    {
        if (isset($where)) {
            $where = " WHERE " . $where;
        }

        $this->sql = "DELETE FROM "
            . $this->prefix
            . $table
            . $where
            . ";\n";
    }



    /**
     * Clear all previous sql-code.
     *
     * @return void
     */
    protected function clear()
    {
        $this->sql      = null;
        $this->columns  = null;
        $this->from     = null;
        $this->join     = null;
        $this->where    = null;
        $this->orderby  = null;
    }



    /**
     * Build a select-query.
     *
     * @param string $columns which columns to select.
     *
     * @return $this
     */
    public function select($columns = '*')
    {
        $this->clear();
        $this->columns = $columns;

        return $this;
    }



    /**
     * Build the from part.
     *
     * @param string $table name of table.
     *
     * @return $this
     */
    public function from($table)
    {
        $this->from = "FROM " . $this->prefix . $table;

        return $this;
    }



    /**
     * Build the inner join part.
     *
     * @param string $table     name of table.
     * @param string $condition to join.
     *
     * @return $this
     */
    public function join($table, $condition)
    {
        $this->join .= "INNER JOIN " . $this->prefix . $table
            . "\n\tON " . $condition . "\n";

        return $this;
    }



    /**
     * Build the where part.
     *
     * @param string $condition for building the where part of the query.
     *
     * @return $this
     */
    public function where($condition)
    {
        $this->where = "WHERE \n\t(" . $condition . ")";

        return $this;
    }



    /**
     * Build the where part with conditions.
     *
     * @param string $condition for building the where part of the query.
     *
     * @return $this
     */
    public function andWhere($condition)
    {
        $this->where .= "\n\tAND (" . $condition . ")";

        return $this;
    }



    /**
     * Build the order by part.
     *
     * @param string $condition for building the where part of the query.
     *
     * @return $this
     */
    public function orderBy($condition)
    {
        $this->orderby = "ORDER BY " . $condition;

        return $this;
    }
}
