<?php 
	 // Versao do modulo: 3.00.010416


	/**
	 * <p>salva faq no banco</p>
	 */
	function cadastroFaq($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			// if (get_magic_quotes_gpc()) 
         $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$dados['pergunta'] = trim($dados['pergunta']);
		$dados['resposta'] = trim($dados['resposta']);

		$dados['ordem'] = 1;
		$ordem = buscaFaq(array('max'=>'ordem'));
		if (!empty($ordem)){
			$ordem = $ordem[0];
			$dados['ordem'] = $ordem['max']+1;
        }
		$sql = "INSERT INTO faq(pergunta, resposta, status, ordem) VALUES (
						'".$dados['pergunta']."',
						'".$dados['resposta']."',
						'".$dados['status']."',
						'".$dados['ordem']."')";
		if (mysqli_query($conexao, $sql)) {
			$resultado = mysqli_insert_id($conexao);
			return $resultado;
		} else {
			return false;
		}
	}

	/**
	 * <p>edita faq no banco</p>
	 */
	function editFaq($dados)
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v)) continue;
			// if (get_magic_quotes_gpc()) 
         $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		$dados['pergunta'] = trim($dados['pergunta']);
		$dados['resposta'] = trim($dados['resposta']);

		$sql = "UPDATE faq SET
						pergunta = '".$dados['pergunta']."',
						resposta = '".$dados['resposta']."',
						status = '".$dados['status']."',
						ordem = '".$dados['ordem']."'
					WHERE idfaq = " . $dados['idfaq'];

		if (mysqli_query($conexao, $sql)) {
			return $dados['idfaq'];
		} else {
			return false;
		}
	}

	/**
	 * <p>busca faq no banco</p>
	 */
	function buscaFaq($dados = array())
	{
		include "includes/mysql.php";

		foreach ($dados AS $k => &$v) {
			if (is_array($v) || $k == "colsSql") continue;
			// if (get_magic_quotes_gpc()) 
         $v = stripslashes($v);
			$v = mysqli_real_escape_string($conexao, utf8_decode($v));
		}

		//busca pelo id
		$buscaId = '';
		if (array_key_exists('idfaq',$dados) && !empty($dados['idfaq']) )
			$buscaId = ' and idfaq = '.intval($dados['idfaq']).' '; 

		//busca pelo pergunta
		$buscaPergunta = '';
		if (array_key_exists('pergunta',$dados) && !empty($dados['pergunta']) )
			$buscaPergunta = ' and pergunta = '.$dados['pergunta'].' ';

        //busca pelo respota
		$buscaRespota = '';
		if (array_key_exists('resposta',$dados) && !empty($dados['resposta']) )
			$buscaRespota = ' and resposta = '.$dados['respota'].' '; 


		//busca pelo status
		$buscaStatus = '';
		if (array_key_exists('status',$dados) && !empty($dados['status']) )
			$buscaStatus = ' and status = "'.$dados['status'].'" ';

		//ordem
        $buscaOrdem = "";
        if (isset($dados['ordenacao']) && !empty($dados['ordenacao'])){
			$buscaOrdem = ' and ordem = '.$dados['ordenacao'] .' ';
        }

        //ordem
        $orderBy = "";
        if (isset($dados['ordem']) && !empty($dados['ordem']) && isset($dados['dir'])){
			$orderBy = ' ORDER BY '.$dados['ordem'] ." ". $dados['dir'];
        }

        //busca pelo limit
		$buscaLimit = '';
		if (array_key_exists('limit',$dados) && !empty($dados['limit']) && array_key_exists('pagina',$dados)) {
            $buscaLimit = ' LIMIT '.($dados['limit'] * $dados['pagina']).','.$dados['limit'].' ';
        } elseif (array_key_exists('limit',$dados) && !empty($dados['limit']) && array_key_exists('inicio',$dados)){
            $buscaLimit = ' LIMIT '.$dados['limit'].','.$dados['inicio'].' ';
        } elseif (array_key_exists('limit',$dados) && !empty($dados['limit'])){
            $buscaLimit = ' LIMIT '.$dados['limit'];
		}
		
		$buscaMax = '';
		if(array_key_exists('max',$dados))
			$buscaMax = ', max('.$dados['max'].') as max ';
			
		//colunas que serão buscadas
		$colsSql = '*';
		if (array_key_exists('totalRecords',$dados)){
			$colsSql = ' count(idfaq) as totalRecords';
            $buscaLimit = '';
            $orderBy = '';
        } elseif (array_key_exists('colsSql',$dados)) {
			$colsSql = ' '.$dados['colsSql'].' ';
		}

		$sql = "SELECT $colsSql $buscaMax FROM faq WHERE 1  $buscaId $buscaPergunta $buscaOrdem $buscaRespota $buscaStatus $orderBy $buscaLimit ";

		$query = mysqli_query($conexao, $sql);
		$resultado = array();
		$iAux = 1;
		$tot =  mysqli_affected_rows($conexao);
		while ($r = mysqli_fetch_assoc($query)){
			$r = array_map('utf8_encode', $r);
			if (!array_key_exists('totalRecords',$dados)){
                $r['ordemUp'] = "";
                $r['ordemDown'] = "";
                if ($iAux != 1){
                        $r['ordemUp'] = '<img src="images/arrUp.png" codigo="'.$r['idfaq'].'" class="link ordemUp" />';
                }
                if ($iAux != $tot){
                        $r['ordemDown'] = '<img src="images/arrDown.png" codigo="'.$r['idfaq'].'" class="link ordemDown"/>';
                }
				$r["status_nome"] = ($r["status"] == 'A' ? "Ativo":"Inativo");
                $r["status_icone"] = '<img src="images/estrela'.($r["status"] =="A" ? "sim":"nao").'.png" class="icone inverteStatus" codigo="'.$r['idfaq'].'" width="20px" />';
                $iAux++;  
            }
			$resultado[] = $r;
		}
		return $resultado; 
 	}

	/**
	 * <p>deleta faq no banco</p>
	 */
	function deletaFaq($dados)
	{
		include "includes/mysql.php";

		$sql = "DELETE FROM faq WHERE idfaq = $dados";
		if (mysqli_query($conexao, $sql)) {
			return mysqli_affected_rows($conexao);
		} else {
			return FALSE;
		}
	}

	// function inverteStatus($dados)
	// {
	//     include "includes/mysql.php";
	   
	//     $sql = "UPDATE faq SET					
	// 					status = '".$dados['status']."'						
	// 				WHERE idfaq = " . $dados['idfaq'];
	    
	//     if (mysqli_query($conexao, $sql)) {
	//         return $dados['idfaq'];
	//     } else {
	//         return false;
	//     }
	// }

?>