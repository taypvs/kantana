<?php
 function encrypted($val) {
  $salt = 'CaGmhRqGGakPZy9'; // DO NOT CHANGE THIS
  $DIV = ':';
  $iv = '';
  $en = '';
  $key = pad_key($salt);
  $cipher = 'AES-256-CBC';

  // ':' が　base64_encode($en)と base64_encode($iv)に含まれないはずだが、万が一に備えて、含まれていないか確認してから返す
  while(true) {
    // $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
    $iv_size = openssl_cipher_iv_length($cipher);
    // $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

    // $en = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, base64_encode($val), MCRYPT_MODE_CBC, $iv);
    $en = openssl_encrypt(base64_encode($val), $cipher, $key, 0, $iv);

    $iv = base64_encode($iv);
    $en = base64_encode($en);

    if ((strpos($iv, $DIV) === false) && (strpos($en, $DIV) === false)) break;
  }
  $cipherRe = str_replace('+', 'noToEns', $iv . $DIV . $en);
  // return $iv . $DIV . $en;
  return $cipherRe;
}


/*
 * 複合化
 *
 *   @param val 暗号化した値
 *   @param key 暗号キー
 *   @return
 *
 ****************************************************************************************************/
 function decrypted($val) {
  $val = str_replace('noToEns', '+', $val);
  $salt = 'CaGmhRqGGakPZy9'; // DO NOT CHANGE THIS
  $DIV = ':';
  $en = explode(':', $val);
  $key=pad_key($salt);
  $cipher = 'AES-256-CBC';
  if (count($en) == 1) {
    return '123';
  }
  else {
    // $de = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($en[1]), MCRYPT_MODE_CBC, base64_decode($en[0]));
    $de = openssl_decrypt(base64_decode($en[1]), $cipher, $key, 0, base64_decode($en[0]));
    return base64_decode($de);
  }
}

function pad_key($key){
  // key is too large
  if(strlen($key) > 32) return false;

  // set sizes
  $sizes = array(16,24,32);

  // loop through sizes and pad key
  foreach($sizes as $s){
      while(strlen($key) < $s) $key = $key."\0";
      if(strlen($key) == $s) break; // finish if the key matches a size
  }

  // return
  return $key;
}

?>
