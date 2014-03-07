<?php
namespace Anax\Validate;

/**
 * A helper to validate variables.
 *
 */
class CValidate 
{

    /**
     * Properties
     *
     */
    const REGEXP_EMAIL = '/\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i';



    /**
     * Check if a value matches rules or throw exception.
     *
     * @param mixed   $value  to check
     * @param string  $rules  to apply when checking value
     * @param boolean $throws set to true to throw exception when check fails
     *
     * @return boolean true or false
     * @throws Exception when check fails
     */
    public function check($value, $rules, $throws = false) 
    {
        $tests = [
            'fail' => [
                'message' => 'Will always fail.', 
                'test' => function() {
                    return false;
                },
            ],
            'pass' => [
                'message' => 'Will always pass.', 
                'test' => function() {
                    return true;
                },
            ],
            'not_empty' => [
                'message' => 'Can not be empty.', 
                'test' => function($value) {
                    return !empty($value);
                },
            ],
            'not_equal' => [
                'message' => 'Not equal.', 
                'test' => function($value, $arg) {
                    return $value != $arg;
                },
            ],
            'numeric' => [
                'message' => 'Must be numeric.', 
                'test' => function($value) {
                    return is_numeric($value);
                }
            ],
            'int' => [
                'message' => 'Must be an integer.', 
                'test' => function($value) {
                    $int = (int) $value;
                    return "$int" == "$value";
                }
            ],
            'range' => [
                'message' => 'Out of range.', 
                'test' => function($value, $min, $max) {
                    return $value >= $min && $value <= $max;
                }
            ],
            'email_adress' => [
                'message' => 'Must be an email adress.', 
                'test' => function($value) { 
                    return preg_match(self::REGEXP_EMAIL, $value) === 1; 
                }
            ],
        ];

        foreach ($rules as $key => $val) {
            $rule = is_int($key) ? $val : $key;

            if (!isset($tests[$rule])) {
                throw new \Exception("Validation rule does not exist.");
            } 
    
            $param = is_int($key) ? null : $val;
            $test  =  $tests[$rule];

            if (is_callable($test['test'])) {

                if (isset($param) && is_array($param)) {
                    $param = array_merge([$value], $param);
                } else if (isset($param)) {
                    $param = [$value, $param];
                } else {
                    $param = [$value];
                }

                if (!call_user_func_array($test['test'], $param)) {
                    if ($throws) {
                        throw new \Exception($test['message']);
                    } else {
                        return false;
                    }
                }
            }
        } 

        return true;
    }
}