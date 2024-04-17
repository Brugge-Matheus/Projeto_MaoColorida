<?php 
	 // Versao do modulo: 3.00.010416
if(!isset($_REQUEST["ajax"]) || empty($_REQUEST["ajax"])){
    require_once 'includes/verifica.php'; // checa user logado
}

if(!isset($_REQUEST["opx"]) || empty($_REQUEST["opx"])) exit;

$opx = $_REQUEST["opx"];

defined("CADASTRO_SERVICOS") || define("CADASTRO_SERVICOS","cadastroServicos");
defined("EDIT_SERVICOS") || define("EDIT_SERVICOS","editServicos");
defined("DELETA_SERVICOS") || define("DELETA_SERVICOS","deletaServicos");
defined("INVERTE_STATUS") || define("INVERTE_STATUS","inverteStatus");
defined("SALVA_IMAGEM") || define("SALVA_IMAGEM","salvaImagem");
defined("LISTA_SERVICOS") || define("LISTA_SERVICOS", "listaServicos");
defined("CANCELAR_IMAGEM") || define("CANCELAR_IMAGEM","cancelarImagem");
defined("EXCLUIR_IMAGEM") || define("EXCLUIR_IMAGEM","excluirImagem");

//GALERIA
   defined("SALVA_GALERIA") || define("SALVA_GALERIA","salvarGaleria");
   defined("SALVAR_DESCRICAO_IMAGEM") || define("SALVAR_DESCRICAO_IMAGEM","salvarDescricao");
   defined("EXCLUIR_IMAGEM_GALERIA") || define("EXCLUIR_IMAGEM_GALERIA","excluirImagemGaleria");
   defined("ALTERAR_POSICAO_IMAGEM") || define("ALTERAR_POSICAO_IMAGEM","alterarPosicaoImagem");
   defined("EXCLUIR_IMAGENS_TEMPORARIAS") || define("EXCLUIR_IMAGENS_TEMPORARIAS","excluiImagensTemporarias");

// URLREWRITE
defined("VERIFICAR_URLREWRITE") || define("VERIFICAR_URLREWRITE", "verificarUrlRewrite");

defined("EXCLUIR_ARQUIVO") || define("EXCLUIR_ARQUIVO","excluirArquivo");   

switch ($opx) {
	case CADASTRO_SERVICOS:
		include_once 'servicos_class.php';
        include_once 'includes/fileImage.php';
        include_once 'includes/functions.php';

	    $dados = $_REQUEST;
        $imagens = $_FILES;

        if (isset($_FILES['icone_upload']) && $_FILES['icone_upload']['error'] == 0) {
            $nomeicone = fileImage("servicos", "", '', $imagens['icone_upload'], 96, 96, 'inside');
            $dados['icone'] = $nomeicone;
        }

        if (isset($_FILES['icone_upload2']) && $_FILES['icone_upload2']['error'] == 0) {
            $nomeicone = fileImage("servicos", "", '', $imagens['icone_upload2'], 96, 96, 'inside');
            $dados['icone2'] = $nomeicone;
        }

        if (isset($_FILES['icone_upload3']) && $_FILES['icone_upload3']['error'] == 0) {
            $nomeicone = fileImage("servicos", "", '', $imagens['icone_upload3'], 96, 96, 'inside');
            $dados['icone3'] = $nomeicone;
        }

        $caminhopasta = "files/imagem";

        if(!file_exists($caminhopasta)){
            mkdir($caminhopasta, 0777);
        }

        //=============Grid com Imagem===============//
        $arrayImg = array();
        if(!empty($imagens['caracteristicas'])){
            foreach($imagens['caracteristicas'] as $key => $imgArray){
                foreach($imgArray as $keyName => $img){
                    $arrayImg[$keyName][$key] = $img['imagem'];          
                }
            }
            foreach($arrayImg as $img){
                $nomeimagem[] = fileImage("caracteristicas", "", "", $img, 50, 50, 'inside');
            }
            foreach($dados['caracteristicas'] as $keys => $imagem){
                foreach($nomeimagem as $key => $names){
                    $dados['caracteristicas'][$key]['imagem'] = $names;
                }
            }
        }

        $arrayImg2 = array();
        if(!empty($imagens['utilizadores'])){
            foreach($imagens['utilizadores'] as $key => $imgArray){
                foreach($imgArray as $keyName => $img){
                    $arrayImg2[$keyName][$key] = $img['imagem'];          
                }
            }
            foreach($arrayImg2 as $img){
                $nomeimagem2[] = fileImage("utilizadores", "", "", $img, 50, 50, 'inside');
            }
            foreach($dados['utilizadores'] as $keys => $imagem){
                foreach($nomeimagem2 as $key => $names){
                    $dados['utilizadores'][$key]['imagem'] = $names;
                }
            }
        }

        $idServicos = cadastroServicos($dados);

		if (is_int($idServicos)) {

            foreach ($dados['idservicos_imagem'] as $key => $idpi) {
                editIdServicos_imagem(array('idservicos'=>$idServicos,'idservicos_imagem'=>$idpi));
            }

			foreach($dados['servicos_faq'] as $keys => $apl){
                $dados['servicos_faq'][$keys]['idservicos'] = $idServicos;
                cadastroServicos_faq($dados['servicos_faq'][$keys]);
            }

			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'servicos';
			$log['descricao'] = 'Cadastrou servicos ID('.$idServicos.') nome ('.$dados['nome'].') urlrewrite ('.$dados['urlrewrite'].') status ('.$dados['status'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=servicos&acao=listarServicos&mensagemalerta='.urlencode('Servicos criado com sucesso!'));
		} else {
			header('Location: index.php?mod=servicos&acao=listarServicos&mensagemerro='.urlencode('ERRO ao criar novo Servicos!'));
		}

	break;

	case EDIT_SERVICOS:
		include_once 'servicos_class.php';
        include_once 'includes/fileImage.php';
        include_once 'includes/functions.php';
      
		$dados = $_REQUEST;
        $imagens = $_FILES;

		$antigo = buscaServicos(array('idservicos'=>$dados['idservicos']));
		$antigo = $antigo[0];

        if (isset($_FILES['icone_upload']) && $_FILES['icone_upload']['error'] == 0) {
            $nomeicone = fileImage("servicos", "", '', $imagens['icone_upload'], 96, 96, 'inside');
            apagarImagemServicos($antigo['icone']);  
            $dados['icone'] = $nomeicone;
        }

        if (isset($_FILES['icone_upload2']) && $_FILES['icone_upload2']['error'] == 0) {
            $nomeicone = fileImage("servicos", "", '', $imagens['icone_upload2'], 96, 96, 'inside');
            $dados['icone2'] = $nomeicone;
        }

        if (isset($_FILES['icone_upload3']) && $_FILES['icone_upload3']['error'] == 0) {
            $nomeicone = fileImage("servicos", "", '', $imagens['icone_upload3'], 96, 96, 'inside');
            $dados['icone3'] = $nomeicone;
        }

      //=============Grid com Imagem===============//
        $arrayImg = array();
        if(!empty($imagens['caracteristicas'])){
            foreach($imagens['caracteristicas'] as $key => $imgArray){
               foreach($imgArray as $keyName => $img){
                  if(!empty($img['imagem'])){
                     $arrayImg[$keyName][$key] = $img['imagem'];
                  }
               }
           }
        }

        $idServicos = editServicos($dados);

      //=============Grid com Imagem===============//
         if(!empty($arrayImg)){
           foreach($arrayImg as $key => $imgsUpload){
               if(!empty($imgsUpload['tmp_name'])){
                   //apagarImagemCaracteristicas($dados['caracteristicas'][$key]['imagem']);
                   $nomeimagem[] = fileImage("caracteristicas", "", "", $imgsUpload, 50, 50, 'inside');
                   foreach($nomeimagem as $names){
                       $dados['caracteristicas'][$key]['imagem'] = $names;
                   }
               }
               elseif($dados['caracteristicas'][$key]['idcaracteristicas'] != 0){
                  // $antigoCaracteristicas = buscaCaracteristicas(array('idcaracteristicas'=>$dados['caracteristicas'][$key]['idcaracteristicas'], 'idservicos' => $idServicos));
                  // $dados['caracteristicas'][$key]['imagem'] = $antigoCaracteristicas[0]['imagem'];
                  $dados['caracteristicas'][$key]['imagem'] = $dados[0]['imagem'];
               }
           }
         } 
         
         if(!empty($dados['servicos_faq'])){

            deletaServicos_faq($idServicos);
            foreach($dados['servicos_faq'] as $keys => $apl){
                $dados['servicos_faq'][$keys]['idservicos'] = $idServicos;
                cadastroServicos_faq($dados['servicos_faq'][$keys]);
            }
        }

		if ($idServicos != FALSE) {

            if(!empty($nomeArquivo)){
                $nomeArquivo = "files/servicos/arquivos/".$nomeArquivo;
                if(!file_exists("files/servicos/arquivos/")){
                    mkdir("files/servicos/arquivos/",0777);
                }

                if(move_uploaded_file($arquivos['tmp_name'], $nomeArquivo)){ 
                    $dados['arquivo'] = $nomeArquivo;
                    $edit = editServicos($dados);
                    apagarArquivoServicos($antigo['arquivo']);
                } 
            }

			//salva log
			include_once 'log_class.php';
			$log['idusuario'] = $_SESSION['sgc_idusuario'];
			$log['modulo'] = 'servicos';
			$log['descricao'] = 'Editou servicos ID('.$idServicos.') DE  nome ('.$antigo['nome'].') urlrewrite ('.$dados['urlrewrite'].') status ('.$antigo['status'].') PARA nome ('.$dados['nome'].') status ('.$dados['status'].')';
			$log['request'] = $_REQUEST;
			novoLog($log);
			header('Location: index.php?mod=servicos&acao=listarServicos&mensagemalerta='.urlencode('Servicos salvo com sucesso!'));
		} else {
			header('Location: index.php?mod=servicos&acao=listarServicos&mensagemerro='.urlencode('ERRO ao salvar Servicos!'));
		}

	break;

	case DELETA_SERVICOS:
		include_once 'servicos_class.php';
		include_once 'usuario_class.php';

		if (!verificaPermissaoAcesso('servicos_deletar', $_SESSION['sgc_idusuario'])){
			header('Location: index.php?mod=servicos&acao=listarServicos&mensagemalerta='.urlencode('Voce nao tem privilegios para executar esta ação!'));
			exit;
		} else {
			$dados = $_REQUEST;
			$antigo = buscaServicos(array('idservicos'=>$dados['idu']));

            apagarImagemServicos($antigo[0]['thumbs']);
            apagarImagemServicos($antigo[0]['banner_topo']);

           // $antigoCaracteristicas = buscaCaracteristicas(array('idservicos'=>$dados['idu']));
            //$antigoUtilizadores = buscaUtilizadores(array('idservicos'=>$dados['idu']));

            // foreach ($antigoCaracteristicas as $key => $oldRec) {
            //     apagarImagemCaracteristicas($oldRec['imagem']);
            // }

			if (deletaServicos($dados['idu']) == 1) {
                //deletaCaracteristicas($dados['idu']);
                //deletaUtilizadores($dados['idu']);
				//salva log
				include_once 'log_class.php';
				$log['idusuario'] = $_SESSION['sgc_idusuario'];
				$log['modulo'] = 'servicos';
				$log['descricao'] = 'Deletou servicos ID('.$dados['idu'].') ';
				$log['request'] = $_REQUEST;
				novoLog($log);
				header('Location: index.php?mod=servicos&acao=listarServicos&mensagemalerta='.urlencode('Servicos deletado com sucesso!'));
			} else {
				header('Location: index.php?mod=servicos&acao=listarServicos&mensagemerro='.urlencode('ERRO ao deletar Servicos!'));
			}
		}

	break;

    case SALVA_IMAGEM:
        include_once('servicos_class.php');
        include_once 'includes/fileImage.php';
        include_once 'includes/functions.php';

        $dados = $_POST;
        $imagem = $_FILES;

        if(!empty($dados['idservicos'])){
            $servicosOld = buscaServicos(array('idservicos'=>$dados['idservicos']));
            $servicosOld = $servicosOld[0];
        }

        if (isset($imagem['imagemCadastrar']) && $imagem['imagemCadastrar']['error'] == 0) {
            $coordenadas = getDataImageCrop($imagem, $dados['coordenadas']);
            $nomeimagem = fileImage("servicos", "", '', $imagem['imagemCadastrar'], $dados['dimensaoWidth'], $dados['dimensaoHeight'], 'cropped', $coordenadas);
            // fileImage("servicos", $nomeimagem, 'original', $imagem['imagemCadastrar'], '', '', 'original');

            $caminho = 'files/servicos/'.$nomeimagem;
            compressImage($caminho);

            if(!empty($dados['idservicos'])){
                if(!empty($servicosOld[$dados['tipo']])){
                    $apgImage = deleteFiles('files/servicos/', $servicosOld[$dados['tipo']], array('', 'thumb_', 'original_'));
                    $servicosOld[$dados['tipo']] = $nomeimagem;
                    $edit = editServicos($servicosOld);
                }else{
                    $servicosOld[$dados['tipo']] = $nomeimagem;
                    $edit = editServicos($servicosOld);
                }
            }

            echo json_encode(array('status'=>true, 'imagem'=>$nomeimagem));
        }else{
            echo json_encode(array('status'=>false, 'msg'=>'Erro ao salvar imagem. Tente novamente'));
        }
    break;

    case CANCELAR_IMAGEM:
        $dados = $_REQUEST;

        if(file_exists('files/'.$dados['pasta'].'/'.$dados['imagem'])){
            unlink('files/'.$dados['pasta'].'/'.$dados['imagem']);
        }

        echo json_encode(array('status'=>true));

    break;

    case EXCLUIR_IMAGEM:
        include_once 'servicos_class.php';
        include_once 'includes/functions.php';

        $dados = $_REQUEST;
        $id = $dados['id'];
        $tipo = $dados['tipo'];
        $img = $dados['img'];
        $servicos = buscaServicos(array('servicos'=>$id));
        $servicos = $servicos[0];

        $imgAntigo = $servicos[$tipo];
        deleteFiles('files/servicos/', $imgAntigo, array('','thumb_','original_'));
        $servicos[$tipo] = '';
        editServicos($servicos);

        echo json_encode(array('status'=>true));

    break;

   case LISTA_SERVICOS:
      include_once 'servicos_class.php';

      $dados = $_REQUEST;
      $listaservicos = buscaServicos($dados);

      echo json_encode($listaservicos);

   break;

   //SALVA IMAGENS DA GALERIA 
   case SALVA_GALERIA:
      include_once ('servicos_class.php');
      include_once 'includes/fileImage.php';
      include_once 'includes/functions.php';

      $dados = $_POST;
      $idservicos = $dados['idservicos'];
      $posicao = $dados['posicao']; 

      $imagem = $_FILES;

      $caminhopasta = "files/servicos/galeria";
      if(!file_exists($caminhopasta)){
         mkdir($caminhopasta, 0777);
      }  

      //galeria grande
      $nomeimagem = fileImage("servicos/galeria", "", "", $imagem['imagem'], 294, 343, 'resize');
      // $thumb = fileImage("servicos/galeria", $nomeimagem, "thumb", $imagem['imagem'], 100, 100, 'crop');
      // fileImage("servicos/galeria", $nomeimagem, "small", $imagem['imagem'], 64, 79, 'crop'); 

      $caminho = $caminhopasta.'/'.$nomeimagem;

      compressImage($caminho);

      //vai cadastrar se já tiver o id do servicos, senao so fica na pasta.
      $idservicos_imagem = $nomeimagem; 

      if(is_numeric($idservicos)){
         //CADASTRAR IMAGEM NO BANCO E TRAZER O ID - EDITANDO GALERIA
         $imagem['idservicos'] = $idservicos;
         $imagem['descricao_imagem'] = "";
         $imagem['posicao_imagem'] = $posicao;
         $imagem['nome_imagem'] = $nomeimagem; 
         $idservicos_imagem = salvaImagemServicos($imagem); 
      } 

      print '{"status":true, "caminho":"'.$caminho.'", "idservicos":"'.$idservicos.'", "idservicos_imagem":"'.$idservicos_imagem.'", "nome_arquivo":"'.$nomeimagem.'"}'; 
   break; 

   case SALVAR_DESCRICAO_IMAGEM:
      include_once('servicos_class.php');
      $dados = $_POST;

      $imagem = buscaServicos_imagem(array("idservicos_imagem"=>$dados['idImagem']));
      $imagem = $imagem[0];
      if($imagem){
         $imagem['descricao_imagem'] = $dados['descricao'];
         if(editServicos_imagem($imagem)){
            print '{"status":true}';
         }else{
            print '{"status":false}';
         }
      }else{
         print '{"status":false}';
      }
   break;

   //EXCLUI A IMAGEM DA GALERIA SELECIONADA
   case EXCLUIR_IMAGEM_GALERIA:

      include_once('servicos_class.php');

      $dados = $_POST;  
      $idservicos = $dados['idservicos'];
      $idservicos_imagem = $dados['idservicos_imagem'];
      $imagem = $dados['imagem']; 

      if(is_numeric($idservicos) && $idservicos > 0){ 
         //esta editando, apagar a imagem da pasta e do banco
         deletarImagemBlogGaleriaServicos($idservicos_imagem, $idservicos);
         $retorno['status'] = apagarImagemBlogServicos($imagem);
      }else{
         //apagar somente a imagem da pastar
         $retorno['status'] = apagarImagemBlogServicos($imagem);
      }  
      print json_encode($retorno);   

   break;

   //ALTERAR POSICAO DA IMAGEM
   case ALTERAR_POSICAO_IMAGEM:

      include_once('servicos_class.php');
      $dados = $_POST;  
      alterarPosicaoImagemServicos($dados);
      print '{"status":true}';

   break; 


   //EXCLUI TODAS AS IMAGENS FEITO NA CADASTRO CANCELADAS
   case EXCLUIR_IMAGENS_TEMPORARIAS: 
      include_once('servicos_class.php');
      $dados = $_POST;  

      if(isset($dados['imagem_servicos'])){
         $imgs = $dados['imagem_servicos'];
         foreach ($imgs as $key => $value) { 
            apagarImagemBlogServicos($value);
         }
      } 
      print '{"status":true}'; 
   break; 

   case EXCLUIR_ARQUIVO: 
        include_once('servicos_class.php');
        $dados = $_POST;

        // print_r($dados);die;
        $return = excluirArquivoServicos($dados);

        if($return == true){
           echo json_encode(array('status'=>true));
        }else{
           echo json_encode(array('status'=>false));
        }
    break; 

    case VERIFICAR_URLREWRITE:
        include_once('servicos_class.php');
        include_once('includes/functions.php');

        $dados = $_POST;

        $urlrewrite = converteUrl(utf8_encode(str_replace(" - ", " ", $dados['urlrewrite'])));
        $urlrewrite = converteUrl(utf8_encode(str_replace("-", " ", $urlrewrite)));

        $url = buscaServicos(array("urlrewrite" => $urlrewrite, "not_idservicos" => $dados['idservicos']));

        if (empty($url)) {
            print '{"status":true,"url":"' . $urlrewrite . '"}';
        } else {
            print '{"status":false,"msg":"Url já cadastrada para outro tratamento"}';
        }

    break;


    case INVERTE_STATUS:
        include_once("servicos_class.php");
        $dados = $_REQUEST;
        // inverteStatus($dados);
        $resultado['status'] = 'sucesso';
        include_once("includes/functions.php");
        $tabela = 'servicos';
        $id = 'idservicos';

        try {
            $servicos = buscaServicos(array('idservicos' => $dados['idservicos']));
            $servicos = $servicos[0];

            // print_r($servicos);
            if($servicos['status'] == 1){
                $status = 0;
            }
            else{
                $status = 1;
            }

            $dadosUpdate = array();
            $dadosUpdate['idservicos'] = $dados['idservicos'];
            $dadosUpdate['status'] = $status;
            inverteStatus($dadosUpdate,$tabela,$id);

            print json_encode($resultado);
        } catch (Exception $e) {
            $resultado['status'] = 'falha';
            print json_encode($resultado);
        }
    break;

	default:
		if (!headers_sent() && (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')) {
			header('Location: index.php?mod=home&mensagemerro='.urlencode('Nenhuma acao definida...'));
		} else {
			trigger_error('Erro...', E_USER_ERROR);
			exit;
		}

}
