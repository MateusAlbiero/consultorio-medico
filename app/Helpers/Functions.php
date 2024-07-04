<?php

function createError($field, $field_message = '* Campo obrigatório', $message = 'Falha na gravação dos dados') {
    return [
       'status' => 'error',
       'message' => $message,
       'field' => $field,
       'field_message' => $field_message
   ];
 }
 
 function logout($logout) {
    return [
       'status' => 'logout',
       'message' => 'true',
   ];
 }

function verifica_cpf($cpf){
   if(strlen($cpf) === 11){
      return 'CPF';
   }else{
      return false;
   }
}

function calc_digitos_posicoes($digitos, $posicoes = 10, $soma_digitos = 0){
   for($i = 0; $i < strlen($digitos); $i++){
      $soma_digitos = $soma_digitos + ($digitos[$i] * $posicoes);
      $posicoes--;

      if ($posicoes < 2){
         $posicoes = 9;
      }
   }

   $soma_digitos = $soma_digitos % 11;
   if($soma_digitos < 2){
      $soma_digitos = 0;
   }else{
      $soma_digitos = 11 - $soma_digitos;
   }
   $cpf = $digitos . $soma_digitos;

   return $cpf;
}

function valida_cpf($cpf){
   $digitos = substr($cpf, 0, 9);
   $novo_cpf = calc_digitos_posicoes($digitos);
   $novo_cpf = calc_digitos_posicoes($novo_cpf, 11);
   if($novo_cpf === $cpf){
      return true;
   }else{
      return false;
   }
}

function formata($cpf, $validar = true){
   $formatado = false;
   if (verifica_cpf($cpf) === 'CPF'){
      if (!$validar || valida_cpf($cpf)){
         $formatado  = substr($cpf, 0, 3) . '.';
         $formatado .= substr($cpf, 3, 3) . '.';
         $formatado .= substr($cpf, 6, 3) . '-';
         $formatado .= substr($cpf, 9, 2) . '';
      }
   }
   return $formatado;
}

function verifica_sequencia($cpf, $multiplos)
	{
		for($i=0; $i<10; $i++) {
			if (str_repeat($i, $multiplos) == $cpf) {
				return false;
			}
		}

		return true;
	}

function formata_cep($cep) {
   return substr($cep, 0, 5).'-'.substr($cep, 5, 3);
}

function formataTelefone($numero){
   if(strlen($numero) == 10){
      $novo = substr_replace($numero, '(', 0, 0);
      $novo = substr_replace($novo, ') ', 3, 0);
      $novo = substr_replace($novo, '-', -4, 0);
      $novo = substr_replace($novo, ' ', -9, 0);
   }else{
      $novo = substr_replace($numero, '(', 0, 0);
      $novo = substr_replace($novo, ' ', 4, 0);
      $novo = substr_replace($novo, ') ', 3, 0);
      $novo = substr_replace($novo, '-', -4, 0);
   }
   return $novo;
}