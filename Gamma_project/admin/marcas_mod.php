<?php 
	 // Versao do modulo: 3.00.010416

	include_once "marcas_class.php";

	if(!isset($_REQUEST['acao']))
		$_REQUEST['acao'] = "";

    $width = 206;
    $height = 46;

    $tamanho = explode('M', ini_get('upload_max_filesize'));
    $tamanho = $tamanho[0].'MB';
?>
<link rel="stylesheet" type="text/css" href="marcas_css.css" />
<script type="text/javascript" src="marcas_js.js"></script>

<!-- CROPPER-->
<link href="css/cropper-padrao.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">

<script src="js/bootstrap.min.js"></script>
<script src="js/cropper.js"></script>
<script src="js/main.js"></script>
<!--************************************
                                         _ _ _
                                        | (_) |
 _ __   _____   _____     ___    ___  __| |_| |_ __ _ _ __
| '_ \ / _ \ \ / / _ \   / _ \  / _ \/ _` | | __/ _` | '__|
| | | | (_) \ V / (_) | |  __/ |  __/ (_| | | || (_| | |
|_| |_|\___/ \_/ \___/   \___|  \___|\__,_|_|\__\__,_|_|
								*******************************-->


<?php if($_REQUEST['acao'] == "formMarcas"){
	if($_REQUEST['met'] == "cadastroMarcas"){
		if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_criar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "marcas_script.php?opx=cadastroMarcas";
		$metodo_titulo = "Cadastro Marcas";
		$idMarcas = 0 ;

		// dados para os campos
		$marcas['nome'] = "";
		$marcas['imagem'] = "";
		$marcas['status'] = "";
	}else{
		if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_editar', $MODULOACESSO['usuario'])) {
			header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
			exit;
		}
		$action = "marcas_script.php?opx=editMarcas";
		$metodo_titulo = "Editar Marcas";
		$idMarcas = (int) $_GET['idu'];
		$marcas = buscaMarcas(array('idmarcas'=>$idMarcas));
		if (count($marcas) != 1) exit;
		$marcas = $marcas[0];
	}
?>

	<div id="titulo">
		<!-- <img src="images/modulos/marcas_preto.png" height="24" width="24" alt="ico" /> -->
		<i class="fas fa-handshake fa-2x"></i>
		<span><?php print $metodo_titulo; ?></span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=marcas&acao=listarMarcas">Listagem</a></li>
			<li class="others_abs_br"></li>
			<li class="other_abs_li"><a href="index.php?mod=marcas&acao=formMarcas&met=cadastroMarcas">Cadastro</a></li> 
		</ul>
	</div>

	<div id="principal">
		<form class="form" name="formMarcas" method="post" enctype="multipart/form-data" action="<?php echo $action; ?>" onsubmit="return verificarCampos(new Array('titulo_aba')); " >

			<div id="informacaoMarcas" class="content">
				<div class="content_tit">Dados Marcas:</div>
					<div class="box_ip">
						<label for="nome">Nome</label>
						<input type="text" name="nome" id="nome" class='' size="30" maxlength="50" value="<?php echo $marcas['nome']; ?>" />
					</div>

					<div class="box_ip">
	                    <div class="box_sel box_txt">
	                      <label for="status">Status</label>
	                      <div class="box_sel_d">
                         	<select name="status" id="status" class=''>
                              	<option value="A" <?=$marcas['status'] == "A" ? ' selected="selected" ' : '';?>> Ativo </option>
                              	<option value="I" <?=$marcas['status'] == "I" ? ' selected="selected" ' : '';?>> Inativo </option>
                          	</select>
	                      </div>
	                   </div>
	                </div>

                    <!-- CROPPER IMG -->
                    <?php $caminho = 'files/marcas/'; ?>
                    <div class="box_ip box_txt pd-left-important">
                        <div class="box_ip box_txt"> 
                            <div class="img_pricipal">
                                <div>
                                    <div class="content_tit">Imagem</div>
                                    <?php if ($marcas['imagem'] != '') { ?>
                                        <div class="box_ip imagem-atual">
                                            <a data-tipo="imagem" data-img="<?=$marcas['imagem']?>" class="excluir-imagem"><img src="images/delete.png" alt="Excluir Imagem"></a>
                                            <img src="<?=$caminho.$marcas['imagem'];?>" class="img-marcas-form" alt=""/>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="box-img-crop">
                                <input type="hidden" value="" name="coordenadas" id="coordenadas" />
                                <div class="docs-buttons">
                                    <div class="btn-group box_txt">
                                        <!--input FILE -->
                                        <input id="" class="cropped-image" name="imagemCadastrar" type="file"/>
                                        <br />
                                        <p class="pre">Tamanho recomendado: <?=$width?>x<?=$height?>px (ou maior proporcional) - Extensão recomendada: png, jpg</p>
                                        <span>O arquivo não pode ser maior que: <?=$tamanho?>
                                        </span>
                                        <input type="hidden" name="maxFileSize" id="maxFileSize" value="<?php echo $tamanho; ?>" />
                                    </div>
                                </div><!-- /.docs-buttons -->
                                <div class="img-container" id="img-container" style="display:none;">
                                    <img alt="">
                                </div>
                                <!-- Show the cropped image in modal -->
                                <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button class="close" data-dismiss="modal" type="button" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="getCroppedCanvasTitle">Cropped</h4>
                                            </div>
                                            <div class="modal-body"></div>
                                        </div>
                                    </div>
                                </div><!-- /.modal -->
                            </div>
                        </div>
                    </div>
    			</div>

			<input type="hidden" name="idmarcas" value="<?php echo $idMarcas; ?>" />
			<input type="submit" value="Salvar" class="bt_save salvar" />
			<input type="button" value="Cancelar" class="bt_cancel cancelar" />
            <input type="hidden" name="imagem" value="<?php echo $marcas['imagem']; ?>" />
            <input type='hidden' name='aspectRatioW' id='aspectRatioW' value='<?=$width?>'>
            <input type='hidden' name='aspectRatioH' id='aspectRatioH' value='<?=$height?>'>
		</form>
	</div>

<?php } ?>



<!--************************************
     _       _        _        _     _
    | |     | |      | |      | |   | |
  __| | __ _| |_ __ _| |_ __ _| |__ | | ___
 / _` |/ _` | __/ _` | __/ _` | '_ \| |/ _ \
| (_| | (_| | || (_| | || (_| | |_) | |  __/
 \__,_|\__,_|\__\__,_|\__\__,_|_.__/|_|\___|
					*******************************-->


<?php if($_REQUEST['acao'] == "listarMarcas"){ ?><?php
	if(!verificaPermissaoAcesso($MODULOACESSO['modulo'].'_visualizar', $MODULOACESSO['usuario']))
		header('Location:index.php?mod=home&mensagemalerta='.urlencode('Voce nao tem privilegios para acessar este modulo!'));
?>
	<div id="titulo">
		<!-- <img src="images/modulos/marcas_preto.png" height="22" width="24" alt="ico" /> -->
		<i class="fas fa-handshake fa-2x"></i>
		<span>Listagem de Marcas</span>
		<ul class="other_abs">
			<li class="other_abs_li"><a href="index.php?mod=marcas&acao=listarMarcas">Listagem</a></li>
			<li class="others_abs_br"></li>
			<li class="other_abs_li"><a href="index.php?mod=marcas&acao=formMarcas&met=cadastroMarcas">Cadastro</a></li>
		</ul>
	</div>
	<div class="search">
		<form name="formbusca" method="post" action="#" onsubmit="return false">
			<input type="text" name="buscarapida" value="Buscar" onblur="campoBuscaEscreve(this);" onfocus="campoBuscaLimpa(this);" id="buscarapida" />
		</form>
		<a href="" class="search_bt">Busca Avançada</a>
	</div>
	<div class="advanced">
		<form name="formAvancado" id="formAvancado" method="post" action="#" onsubmit="return false">
			<p class="advanced_tit">Busca Avançada</p>
			<img class="advanced_close" src="images/ico_close.png" height="10" width="11" alt="ico" />
			<div class="box_ip"><label for="adv_titulo_aba">Título</label><input type="text" name="titulo" id="adv_titulo_aba"></div>
         <div class="box_ip">
             <div class="box_sel box_txt">
                 <label for="adv_status">Status</label>
                 <div class="box_sel_d">
                     <select name="status" id="adv_status">
                         <option></option>
                         <option value="A"> Ativo </option>
                         <option value="I"> Inativo </option>
                     </select>
                 </div>
            </div>
         </div>
			<a href="" class="advanced_bt" id="filtrar">Filtrar</a>
		</form>
	</div>




	<div id="principal" >
		<div id="abas">
			<ul class="abas_list">
				<li class="abas_list_li action"><a href="javascript:void(0)">Marcas</a></li>
			</ul>
			<ul class="abas_bts">
				<li class="abas_bts_li"><a href="index.php?mod=marcas&acao=formMarcas&met=cadastroMarcas"><img src="images/novo.png" alt="Cadastro Marcas" title="Cadastrar Marcas" /></a></li>
				<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=marcas&output=print&'+queryDataTable);"><img src="images/imprimir.png" alt="Imprimir listagem" title="Imprimir listagem"></a></li>
				<li class="abas_bts_li"><a href="javascript:void(0)" onclick="popUp('relatorio_class.php?modulo=marcas&output=xls&'+queryDataTable);"><img src="images/excel.png" alt="Exportar para o Excel" title="Exportar para o Excel"  ></a></li>
			</ul>
		</div>
		<table class="table" cellspacing="0" cellpadding="0" id="listagem">
			<thead>
			</thead>
			<tbody>
			</tbody>
		</table>
		<?php include_once("paginacao/paginacao.php"); ?> 




		<?php
			$dados = isset($_POST) ? $_POST : array();
			$buscar = '';
			foreach($dados as $k=>$v){
				if(!empty($v))
					$buscar .= $k.'='.$v.'&';
			}
		?>


		<script type="text/javascript">
			queryDataTable = '<?php print $buscar; ?>';
			requestInicio = "tipoMod=marcas&p="+preventCache+"&";
			ordem = "idmarcas";
			dir = "desc";
			$(document).ready(function(){
				preTableMarcas();
			});
			dataTableMarcas('<?php print $buscar; ?>');
			columnMarcas();
		</script>




	</div>

<?php } ?>

<div id="modal-confirmacao">
    <form class="form" method="post">
        <input type="button" value="NÃO" class="button cancel" />
        <input type="button" value="SIM" class="button confirm"/>
    </form>
</div>