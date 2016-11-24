<?php

$destaqueVet = array("Sim", "Não");
$unidadeVet = array("Caixa","Unidade","Duzia");

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}	
?>