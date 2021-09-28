<?php

function visualizzaPrimoCalendario($DataIniziale,$DataFinale){
 
  $myCalendar = new tc_calendar("date3", true, false);
  $myCalendar->setIcon("../object/calendar/images/iconCalendar.gif");
  $myCalendar->setDate(date('d', strtotime($DataIniziale)), date('m', strtotime($DataIniziale)), date('Y', strtotime($DataIniziale)));
  $myCalendar->setPath("../object/calendar/");
  $myCalendar->setYearInterval(1970, 2030);
  $myCalendar->setAlignment('left', 'bottom');
  $myCalendar->setDatePair('date3', 'date4', $DataFinale);
  $myCalendar->writeScript();
 
}

function visualizzaSecondoCalendario($DataIniziale,$DataFinale){
  $myCalendar = new tc_calendar("date4", true, false);
  $myCalendar->setIcon("../object/calendar/images/iconCalendar.gif");
  $myCalendar->setDate(date('d', strtotime($DataFinale)), date('m', strtotime($DataFinale)), date('Y', strtotime($DataFinale)));
  $myCalendar->setPath("../object/calendar/");
  $myCalendar->setYearInterval(1970, 2030);
  $myCalendar->setAlignment('left', 'bottom');
  $myCalendar->setDatePair('date3', 'date4', $DataIniziale);
  $myCalendar->writeScript();
}

?>
