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
    private const REGEXP_EMAIL = '/\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i';



    /**
     * Check if a value matches rules or throw exception.
     *
     * @param mixed $value to check
     * @param string $rules to apply when checking value
     * @return $value
     * @throws Exception when check fails
     */
    public function check($value, $rules) 
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
                'message' => 'Value not valid.', 
                'test' => function($value, $arg) {
                    return $value != $arg;
                },
            ],
            'numeric' => [
                'message' => 'Must be numeric.', 
                'test' => function() use($value) {
                    return true;
                }'return is_numeric($value);'
            ],
            'email_adress' => [
                'message' => 'Must be an email adress.', 
                'test' => function($value) { 
                    return preg_match(self::REGEXP_EMAIL, $value) === 1; 
                }.
            ],
            'match' => [
                'message' => 'The field does not match.', 
                'test' => function() use($value) {
                    return true;
                }'return $value == $form[$arg]["value"] ;'
            ],
            'must_accept' => array('message' => 'You must accept this.', 'test' => function() use($value) {
                    return true;
                }'return $checked;'),
            'custom_test' => true,
        ];

        $set = [
            'int'   => 'is_int',
            '>'     => ''
        ];
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }


    $pass = true;
    $messages = array();
    $value = $this['value'];
    $checked = $this['checked'];

    foreach($rules as $key => $val) {
      $rule = is_numeric($key) ? $val : $key;
      if(!isset($tests[$rule])) throw new Exception("Validation of form element failed, no such validation rule exists: $rule");
      $arg = is_numeric($key) ? null : $val;

      $test = ($rule == 'custom_test') ? $arg : $tests[$rule];
      $status = null;
      if(is_callable($test['test'])) {
        $status = $test['test']($value);
      } else {
        $status = eval($test['test']);
      }

      if($status === false) {
        $messages[] = $test['message'];
        $pass = false;
      }
    }

    if(!empty($messages)) {
      $this['validation-messages'] = $messages;
    } 
    return $pass;


}