<?php
/**
 * Theme related functions. 
 *
 */

/**
 * Get HTML for favicon if favicon is defined.
 *
 * @returns string/null wether the favicon is defined or not.
 */
function favicon() {
  global $anax;

  if(isset($anax['favicon'])) {
    return "<link rel='shortcut icon' href='{$anax['favicon']}'/>\n";
  }

  return null;
}



