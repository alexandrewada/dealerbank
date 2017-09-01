<?php
    
    function somenteNumeros($string){
      return preg_replace('/[^0-9]/',"",trim($string));
    }

    function mask($val, $mask)
    {
     $maskared = '';
     $k = 0;
     for($i = 0; $i<=strlen($mask)-1; $i++)
     {
     if($mask[$i] == '#')
     {
     if(isset($val[$k]))
     $maskared .= $val[$k++];
     }
     else
     {
     if(isset($mask[$i]))
     $maskared .= $mask[$i];
     }
     }
     return $maskared;
    }

    function qtdProximoDiaUtil($data, $saida = 'Y-m-d') {
        // Converte $data em um UNIX TIMESTAMP
        $timestamp = strtotime($data);
        // Calcula qual o dia da semana de $data
        // O resultado será um valor numérico:
        // 1 -> Segunda ... 7 -> Domingo
        $dia = date('N', $timestamp);
        // Se for sábado (6) ou domingo (7), calcula a próxima segunda-feira
        if ($dia >= 6) {
          $timestamp_final = $timestamp + ((8 - $dia) * 3600 * 24);
        } else {
        // Não é sábado nem domingo, mantém a data de entrada
          $timestamp_final = $timestamp;
        }

        $data_final           = date('Y-m-d',$timestamp_final);
        
        $data_operacao        = new DateTime($data);
        $data_vencimento      = new DateTime($data_final);
        $intervalo            = $data_operacao->diff($data_vencimento);
        $float                = $intervalo->format('%a');

        return $float;
    }

    function removerAcento($string, $slug = false) {
      $string = strtolower($string);
      // Código ASCII das vogais
      $ascii['a'] = range(224, 230);
      $ascii['e'] = range(232, 235);
      $ascii['i'] = range(236, 239);
      $ascii['o'] = array_merge(range(242, 246), array(240, 248));
      $ascii['u'] = range(249, 252);
      // Código ASCII dos outros caracteres
      $ascii['b'] = array(223);
      $ascii['c'] = array(231);
      $ascii['d'] = array(208);
      $ascii['n'] = array(241);
      $ascii['y'] = array(253, 255);
      foreach ($ascii as $key=>$item) {
        $acentos = '';
        foreach ($item AS $codigo) $acentos .= chr($codigo);
        $troca[$key] = '/['.$acentos.']/i';
      }
      $string = preg_replace(array_values($troca), array_keys($troca), $string);
      // Slug?
      if ($slug) {
        // Troca tudo que não for letra ou número por um caractere ($slug)
        $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
        // Tira os caracteres ($slug) repetidos
        $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
        $string = trim($string, $slug);
      }
      return $string;
    }
?>