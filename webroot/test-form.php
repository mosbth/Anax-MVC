<?php
/**
 * This is a Anax pagecontroller.
 *
 */

require __DIR__.'/config_with_app.php';


// TODO: Learn/adapt how to add external resources e.g. fonts
// $app->theme->addStylesheet('https://fonts.googleapis.com/css?family=Raleway:400,200');
// $app->theme->setVariable('me-fonts', 'https://fonts.googleapis.com/css?family=Pragati+Narrow');
$app->router->add('', function () use ($app) {
    $app->theme->setTitle("Om mig");
    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ]);
});

$app->router->add('redovisning', function () use ($app) {
    $app->theme->setTitle("Redovisning");
    $content = $app->fileContent->get('report.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ]);

});

// Test CForm
$di->set('form', '\Mos\HTMLForm\CForm');

$app->router->add('form/array', function () use ($app) {

    $app->session;

    $form = $app->form;

    $form = $form->create([], [
        'name' => [
            'type'        => 'text',
            'label'       => 'Name of contact person:',
            'required'    => true,
            'validation'  => ['not_empty'],
        ],
        'email' => [
            'type'        => 'text',
            'required'    => true,
            'validation'  => ['not_empty', 'email_adress'],
        ],
        'phone' => [
            'type'        => 'text',
            'required'    => true,
            'validation'  => ['not_empty', 'numeric'],
        ],
        'submit' => [
            'type'      => 'submit',
            'callback'  => function ($form) {
                $form->AddOutput("<p><i>DoSubmit(): Form was submitted. Do stuff (save to database) and return true (success) or false (failed processing form)</i></p>");
                $form->AddOutput("<p><b>Name: " . $form->Value('name') . "</b></p>");
                $form->AddOutput("<p><b>Email: " . $form->Value('email') . "</b></p>");
                $form->AddOutput("<p><b>Phone: " . $form->Value('phone') . "</b></p>");
                $form->saveInSession = true;
                return true;
            }
        ],
        'submit-fail' => [
            'type'      => 'submit',
            'callback'  => function ($form) {
                $form->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
                return false;
            }
        ],
    ]);

    // Check the status of the form
    $status = $form->check();

    if ($status === true) {

        // What to do if the form was submitted?
        $form->AddOUtput("<p><i>Form was submitted and the callback method returned true.</i></p>");
        header("Location: " . $_SERVER['PHP_SELF']);

    } elseif ($status === false) {

        // What to do when form could not be processed?
        $form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
        header("Location: " . $_SERVER['PHP_SELF']);
    }

    $app->theme->setTitle("CForm using array");
    $app->views->add('welcome/page', [
        'title' => "Try out a form using CForm",
        'content' => $form->getHTML()
    ]);

});

// Adapted from Java code at http://www.merriampark.com/anatomycc.htm
// by Andy Frey, onesandzeros.biz
// Checks for valid credit card number using Luhn algorithm
// Source from: http://onesandzeros.biz/notebook/ccvalidation.php
//
// Try the following numbers, they should be valid according to the check:
// 4408 0412 3456 7893
// 4417 1234 5678 9113
//
function isValidCCNumber($ccNum)
{
    $digitsOnly = "";
    // Filter out non-digit characters
    for ($i = 0; $i < strlen($ccNum); $i++) {
        if (is_numeric(substr($ccNum, $i, 1))) {
            $digitsOnly .= substr($ccNum, $i, 1);
        }
    }
    // Perform Luhn check
    $sum = 0;
    $digit = 0;
    $addend = 0;
    $timesTwo = false;
    for ($i = strlen($digitsOnly) - 1; $i >= 0; $i--) {
        $digit = substr($digitsOnly, $i, 1);
        if ($timesTwo) {
            $addend = $digit * 2;
            if ($addend > 9) {
                $addend -= 9;
            }
        } else {
            $addend = $digit;
        }
        $sum += $addend;
        $timesTwo = !$timesTwo;
    }
    return $sum % 10 == 0;
}

$app->router->add('form/creditcard', function () use ($app) {

    $app->session;

    $form = $app->form;

    $currentYear = date('Y');
    $elements = array(
      'payment' => array(
        'type' => 'hidden',
        'value' => 10
      ),
      'name' => array(
        'type' => 'text',
        'label' => 'Name on credit card:',
        'required' => true,
        'autofocus' => true,
        'validation' => array('not_empty')
      ),
      'address' => array(
        'type' => 'text',
        'required' => true,
        'validation' => array('not_empty')
      ),
      'zip' => array(
        'type' => 'text',
        'required' => true,
        'validation' => array('not_empty')
      ),
      'city' => array(
        'type' => 'text',
        'required' => true,
        'validation' => array('not_empty')
      ),
      'country' => array(
        'type' => 'select',
        'options' => array(
          'default' => 'Select a country...',
          'no' => 'Norway',
          'se' => 'Sweden',
        ),
        'validation' => array('not_empty', 'not_equal' => 'default')
      ),
      'cctype' => array(
        'type' => 'select',
        'label' => 'Credit card type:',
        'options' => array(
          'default' => 'Select a credit card type...',
          'visa' => 'VISA',
          'mastercard' => 'Mastercard',
          'eurocard' => 'Eurocard',
          'amex' => 'American Express',
        ),
        'validation' => array('not_empty', 'not_equal' => 'default')
      ),
      'ccnumber' => array(
        'type' => 'text',
        'label' => 'Credit card number:',
        'validation' => array('not_empty', 'custom_test' => array('message' => 'Credit card number is not valid, try using 4408 0412 3456 7893 or 4417 1234 5678 9113 :-).', 'test' => 'isValidCCNumber')),
      ),
      'expmonth' => array(
        'type' => 'select',
        'label' => 'Expiration month:',
        'options' => array(
          'default' => 'Select credit card expiration month...',
          '01' => 'January',
          '02' => 'February',
          '03' => 'March',
          '04' => 'April',
          '05' => 'May',
          '06' => 'June',
          '07' => 'July',
          '08' => 'August',
          '09' => 'September',
          '10' => 'October',
          '11' => 'November',
          '12' => 'December',
        ),
        'validation' => array('not_empty', 'not_equal' => 'default')
      ),
      'expyear' => array(
        'type' => 'select',
        'label' => 'Expiration year:',
        'options' => array(
          'default' => 'Select credit card expiration year...',
          $currentYear    => $currentYear,
          ++$currentYear  => $currentYear,
          ++$currentYear  => $currentYear,
          ++$currentYear  => $currentYear,
          ++$currentYear  => $currentYear,
          ++$currentYear  => $currentYear,
        ),
        'validation' => array('not_empty', 'not_equal' => 'default')
      ),
      'cvc' => array(
        'type' => 'text',
        'label' => 'CVC:',
        'required' => true,
        'validation' => array('not_empty', 'numeric')
      ),
      'doPay' => array(
        'type' => 'submit',
        'value' => 'Perform payment',
        'callback' => function ($form) {
          // Taking some money from the creditcard.
            return true;
        }
      ),
    );

    $form = new \Mos\HTMLForm\CForm(array(), $elements);

    // Check the status of the form
    $status = $form->Check();

    // What to do if the form was submitted?
    if ($status === true) {
        $form->AddOUtput("<p><i>Form was submitted and the callback method returned true.</i></p>");
        header("Location: " . $_SERVER['PHP_SELF']);
    } elseif ($status === false) {
        // What to do when form could not be processed?
        $form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
        header("Location: " . $_SERVER['PHP_SELF']);
    }

    $app->theme->setTitle("Creditcard checkout");
    $app->views->add('welcome/page', [
        'title' => "CForm Example: Creditcard checkout",
        'content' => $form->getHTML()
    ]);

});

$app->router->add('form/searchwidget', function () use ($app) {

    $app->session;

    $form = $app->form;

    $form = new \Mos\HTMLForm\CFMSearchWidget();
    $form->Check();

    $app->theme->setTitle("Search widget");
    $app->views->add('welcome/page', [
        'title' => "Example: Search widget",
        'content' => $form->getHTML()
    ]);

});

// Test form route
$app->router->add('test1', function () use ($app) {

    $form = $app->form->create([], [
        'name' => [
            'type'        => 'text',
            'label'       => 'Name of contact person:',
            'required'    => true,
            'validation'  => ['not_empty'],
        ],
        'email' => [
            'type'        => 'text',
            'required'    => true,
            'validation'  => ['not_empty', 'email_adress'],
        ],
        'phone' => [
            'type'        => 'text',
            'required'    => true,
            'validation'  => ['not_empty', 'numeric'],
        ],
        'submit' => [
            'type'      => 'submit',
            'callback'  => function ($form) {
                $form->AddOutput("<p><i>DoSubmit(): Form was submitted. Do stuff (save to database) and return true (success) or false (failed processing form)</i></p>");
                $form->AddOutput("<p><b>Name: " . $form->Value('name') . "</b></p>");
                $form->AddOutput("<p><b>Email: " . $form->Value('email') . "</b></p>");
                $form->AddOutput("<p><b>Phone: " . $form->Value('phone') . "</b></p>");
                $form->saveInSession = true;
                return true;
            }
        ],
        'submit-fail' => [
            'type'      => 'submit',
            'callback'  => function ($form) {
                $form->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
                return false;
            }
        ],
    ]);

    // Check the status of the form
    $status = $form->check();

    if ($status === true) {

        // What to do if the form was submitted?
        $form->AddOUtput("<p><i>Form was submitted and the callback method returned true.</i></p>");
        header("Location: " . $_SERVER['PHP_SELF']);

    } else if ($status === false) {

        // What to do when form could not be processed?
        $form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
        header("Location: " . $_SERVER['PHP_SELF']);
    }

    $app->theme->setTitle("CForm Example");
    $app->views->add('default/page', [
        'title' => "Try out a form using CForm",
        'content' => $form->getHTML()
    ]);

});

$app->router->handle();
$app->theme->render();
