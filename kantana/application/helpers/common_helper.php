<?php
// Add Leading Zeros To A Number
function addZeroToNumber($number){
  $number_length = 4;
  $numberResult = substr("0000{$number}", -$number_length);
  return $numberResult;
}

function getLastRegisterId ($list_item) {
  if (count($list_item) > 0){
    $last_item = end ($list_item);
    return $last_item['id'];
  } else {
    return 0;
  }
}

function getLastMonth($date){
  $date = date("Y-m-d");
  $dateTime = new DateTime($date);
  $lastMonth = $dateTime->modify('-' . $dateTime->format('d') . ' days')->format('m');
  return $lastMonth;
}

function formatDate($date){
  $newDate = date("Y-m-d", strtotime($date));
  return $newDate;
}

function remove_format($text){
  $text = str_replace(",", "", $text);
return $text;
}
?>
