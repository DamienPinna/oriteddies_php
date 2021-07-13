<?php

function secureHTML($string) {
  return htmlentities($string);
}

// filter_var($text, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
// filter_var($text, FILTER_SANITIZE_EMAIL);
// filter_var_array($array, [
//   'email' => FILTER_SANITIZE_EMAIL,
//   'text' => [
//     'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
//     'flag' => FILTER_FLAG_NO_ENCODE_QUOTES
//   ],
//   'number' => FILTER_SANITIZE_NUMBER_INT
// ]);