<aside class="menu bg <?=(!isset($_SESSION['lateral']) ? "open" : $_SESSION['lateral'] );?>">
  <div class="bg_menu bg <?=(!isset($_SESSION['lateral']) || $_SESSION['lateral'] == "open" ? "" : 'close' );?>"></div>
  <h1 class="menu_logo"><a href="<?=ENDERECO?>" class="menu_logo_a">
   <?php print_r(ENDERECO)?>
    <img src="images/cliente/logo.png"  width="143" alt="ico" />
    <img class="logo_close" src="images/cliente/logo_small.png" height="39" width="30" alt="ico" />
  </a></h1>
  <h2 class="menu_tit">Sistema de Gestão Web</h2>
  <div class="menu_bts">
    <div class="menu_bts_inner">
      <a href="http://www.agencia.red/contact" class="menu_bts_li" target="_blank"><img src="images/doubt.png" height="30" width="55" alt="ico" /></a>
      <a href="?mod=usuario&acao=formUsuario&met=editaUsuario&idu=<?=$_SESSION['sgc_idusuario'];?>" class="menu_bts_li"><img src="images/key.png" height="30" width="55" alt="ico" /></a>
      <a href="" id="logoffBtn" class="menu_bts_li"><img src="images/off.png" height="30" width="55" alt="ico" /></a>
      
      <!-- ADD ICON MENU -->

      <a href='#' id='mobHambBtn' onclick="showMenuMob(this)" class='menu_bts_li'><img src='css/menumob.png' height='30' width='55' alt='ico'></a>
      <script>
        function showMenuMob() {
          $(".menu_ul, .menu_user, .menu_sec").fadeToggle();

        }
      </script>

      <!-- STOP ICON MENU -->


    </div>
  </div>
  <div class="menu_user">
    <div class="menu_user_inner">
      <img src="<?= !empty($_SESSION['sgc_foto'])? "files/images/thumbs2/".$_SESSION['sgc_foto'] : "http://placehold.it/36x36" ?>" alt="img" class="alteraImagem" />
      <span><?=ucwords($_SESSION['sgc_nome'])?></span>
      <ul class="huser_menu">
        <li class="huser_menu_li"><a href="?mod=usuario&acao=formUsuario&met=editaUsuario&idu=<?=$_SESSION['sgc_idusuario'];?>">Meus Dados</a></li>
        <li class="huser_menu_li"><a href="javascript:void(0)" class="alteraImagem">Alterar Foto</a></li>
        <!-- <li class="huser_menu_li"><a href="">Alterar Senha</a></li> -->
        <li class="huser_menu_li"><a href="usuario_script.php?opx=logout">Sair</a></li>
      </ul>
    </div>
  </div>
  <div class="menu_sec">
    <input type="text" class="menu_sec_ip" placeholder="Buscar" />
  </div>
  <ul class="menu_ul">
    <li class="menu_ul_li none"><a class="menu_ul_li_a" href="index.php"><i class="fa-icon fas fa-home"></i>Home</a></li>

   <?php if(verificaPermissaoAcesso('banner_visualizar', $MODULOACESSO['usuario'])){ ?>
      <li class="menu_ul_li">
         <a class="menu_ul_li_a"><i class="fa-icon fas fa-image" aria-hidden="true"></i> Banner</a>
         <ul>
            <li class="li-title-mobile">Banner</li>
            <li><a href="index.php?mod=banner&amp;acao=listarBanner">• Consulta</a></li>
            <?php if(verificaPermissaoAcesso('banner_criar', $MODULOACESSO['usuario'])): ?>
               <li><a href="index.php?mod=banner&amp;acao=formBanner&amp;met=cadastroBanner">• Cadastro</a></li>
            <?php endif;?>
         </ul>
      </li>
   <?php } ?>

   <?php if(verificaPermissaoAcesso('trabalhe_conosco_visualizar', $MODULOACESSO['usuario']) || verificaPermissaoAcesso('area_pretendida_visualizar', $MODULOACESSO['usuario'])){ ?>
      <li class="menu_ul_li">
         <a class="menu_ul_li_a"><i class='fa-icon fas fa-file-archive' aria-hidden="true"></i>Currículos</a>
         <ul>
            <li class="li-title-mobile">Currículos</li>
            <?php if(verificaPermissaoAcesso('area_pretendida_visualizar', $MODULOACESSO['usuario'])){ ?>
               <li><a href="index.php?mod=area_pretendida&amp;acao=listarArea_pretendida">• Áreas</a></li> 
            <?php } ?>
            <?php if(verificaPermissaoAcesso('trabalhe_conosco_visualizar', $MODULOACESSO['usuario'])){ ?>
               <li><a href="index.php?mod=trabalhe_conosco&amp;acao=listarTrabalhe_conosco">• Currículos</a></li>
            <?php } ?>   
         </ul>
      </li>  
   <?php } ?>

   <?php if (verificaPermissaoAcesso('blog_post_visualizar', $MODULOACESSO['usuario'])) { ?>
      <li class="menu_ul_li">
         <a class="menu_ul_li_a"><i class='fa-icon fas fa-rss' aria-hidden="true"></i>Blog</a>
         <ul>
            <li class="li-title-mobile">Blog</li>
            <?php if (verificaPermissaoAcesso('blog_post_visualizar', $MODULOACESSO['usuario'])) { ?>
               <li><a href="index.php?mod=blog_post&amp;acao=listarBlog_post">• Posts</a></li>
            <?php } ?>
            <?php if (verificaPermissaoAcesso('blog_categoria_visualizar', $MODULOACESSO['usuario'])) { ?>
               <li><a href="index.php?mod=blog_categoria&amp;acao=listarBlog_categoria">• Categorias</a></li>
            <?php } ?>
            <?php if (verificaPermissaoAcesso('blog_tags_visualizar', $MODULOACESSO['usuario'])) { ?>
               <li><a href="index.php?mod=blog_tags&amp;acao=listarBlog_tags">• Tags</a></li>
            <?php } ?>
            <?php if (verificaPermissaoAcesso('blog_comentarios_visualizar', $MODULOACESSO['usuario'])) { ?>
               <li><a href="index.php?mod=blog_comentarios&amp;acao=listarBlog_comentarios">• Comentários</a></li>
            <?php } ?>
         </ul>
      </li>
   <?php } ?>

   <?php if (verificaPermissaoAcesso('contatos_visualizar', $MODULOACESSO['usuario'])) { ?>
      <li class="menu_ul_li">
         <a class="menu_ul_li_a"><i class='fa-icon fas fa-user' aria-hidden="true"></i>Contatos</a>
         <ul>
            <li class="li-title-mobile">Contatos</li>
            <li><a href="index.php?mod=contatos&amp;acao=listarContatos">• Consulta</a></li>
            <?php if(verificaPermissaoAcesso('orcamento_visualizar', $MODULOACESSO['usuario'])): ?>
               <li><a href="index.php?mod=orcamento&amp;acao=listarOrcamento">• Consulta Orçamentos</a></li>
            <?php endif;?>
         </ul>
      </li>
   <?php } ?>

   <?php if (verificaPermissaoAcesso('depoimento_visualizar', $MODULOACESSO['usuario'])) { ?>
      <li class="menu_ul_li">
         <a class="menu_ul_li_a"><i class='fa-icon fas fa-comment' aria-hidden="true"></i>Depoimento</a>
         <ul>
            <li class="li-title-mobile">Depoimento</li>
            <li><a href="index.php?mod=depoimento&amp;acao=listarDepoimento">• Consulta</a></li>
            <?php if(verificaPermissaoAcesso('depoimento_criar', $MODULOACESSO['usuario'])): ?>
               <li><a href="index.php?mod=depoimento&amp;acao=formDepoimento&amp;met=cadastroDepoimento">• Cadastro</a></li>
            <?php endif;?>
         </ul>
      </li>
   <?php } ?>

   <?php if (verificaPermissaoAcesso('equipe_visualizar', $MODULOACESSO['usuario'])) { ?>
      <li class="menu_ul_li">
         <a class="menu_ul_li_a"><i class='fa-icon fas fa-users' aria-hidden="true"></i>Equipe</a>
         <ul>
            <li class="li-title-mobile">Equipe</li>
            <li><a href="index.php?mod=equipe&amp;acao=listarEquipe">• Consulta</a></li>
            <?php if(verificaPermissaoAcesso('equipe_criar', $MODULOACESSO['usuario'])): ?>
               <li><a href="index.php?mod=equipe&amp;acao=formEquipe&amp;met=cadastroEquipe">• Cadastro</a></li>
            <?php endif;?>
         </ul>
      </li>
   <?php } ?>

   <?php if (verificaPermissaoAcesso('segmento_visualizar', $MODULOACESSO['usuario'])) { ?>
      <li class="menu_ul_li">
         <a class="menu_ul_li_a"><i class='fa-icon fas fa-inbox' aria-hidden="true"></i>Segmento</a>
         <ul>
            <li class="li-title-mobile">Segmento</li>
            <li><a href="index.php?mod=segmento&amp;acao=listarSegmento">• Consulta</a></li>
            <?php if(verificaPermissaoAcesso('segmento_criar', $MODULOACESSO['usuario'])): ?>
               <li><a href="index.php?mod=segmento&amp;acao=formSegmento&amp;met=cadastroSegmento">• Cadastro</a></li>
            <?php endif;?>
            <?php if(verificaPermissaoAcesso('segmento_diferenciais_criar', $MODULOACESSO['usuario'])): ?>
               <li><a href="index.php?mod=segmento_diferenciais&amp;acao=formSegmento_diferenciais&amp;met=cadastroSegmento_diferenciais">• Diferenciais</a></li>
            <?php endif;?>
         </ul>
      </li>
   <?php } ?>

   <?php if (verificaPermissaoAcesso('documentos_visualizar', $MODULOACESSO['usuario'])) { ?>
      <li class="menu_ul_li">
         <a class="menu_ul_li_a"><i class='fa-icon fas fa-book-open' aria-hidden="true"></i>Catálogos</a>
         <ul>
            <li class="li-title-mobile">Catálogos</li>
            <li><a href="index.php?mod=documentos&amp;acao=listarDocumentos">• Consulta</a></li>
            <?php if(verificaPermissaoAcesso('documentos_criar', $MODULOACESSO['usuario'])): ?>
               <li><a href="index.php?mod=documentos&amp;acao=formDocumentos&amp;met=cadastroDocumentos">• Cadastro</a></li>
            <?php endif;?>
         </ul>
      </li>
   <?php } ?>
   
   <?php if (verificaPermissaoAcesso('faq_visualizar', $MODULOACESSO['usuario'])) { ?>
      <li class="menu_ul_li">
         <a class="menu_ul_li_a"><i class='fa-icon fas fa-question' aria-hidden="true"></i>Faq</a>
         <ul>
            <li class="li-title-mobile">Faq</li>
            <li><a href="index.php?mod=faq&amp;acao=listarFaq">• Consulta</a></li>
            <?php if(verificaPermissaoAcesso('faq_criar', $MODULOACESSO['usuario'])): ?>
               <li><a href="index.php?mod=faq&amp;acao=formFaq&amp;met=cadastroFaq">• Cadastro</a></li>
            <?php endif;?>
         </ul>
      </li>
   <?php } ?>
   <?php if (verificaPermissaoAcesso('produto_visualizar', $MODULOACESSO['usuario']) || 
            verificaPermissaoAcesso('categoria_visualizar', $MODULOACESSO['usuario']) || 
            verificaPermissaoAcesso('linhas_visualizar', $MODULOACESSO['usuario'])) { ?>
      <li class="menu_ul_li">
         <a class="menu_ul_li_a"><i class='fa-icon fas fa-rss' aria-hidden="true"></i>Produtos</a>
         <ul>
            <li class="li-title-mobile">Produtos</li>
            <?php if (verificaPermissaoAcesso('produto_visualizar', $MODULOACESSO['usuario'])) { ?>
               <li><a href="index.php?mod=produto&amp;acao=listarProduto">• Consulta</a></li>
            <?php } ?>
            <?php if (verificaPermissaoAcesso('categoria_visualizar', $MODULOACESSO['usuario'])) { ?>
               <li><a href="index.php?mod=categoria&amp;acao=listarCategoria">• Categoria</a></li>
            <?php } ?>
            <?php if (verificaPermissaoAcesso('linhas_visualizar', $MODULOACESSO['usuario'])) { ?>
               <li><a href="index.php?mod=linhas&amp;acao=listarLinhas">• Linhas</a></li>
            <?php } ?>
            <?php if (verificaPermissaoAcesso('marcas_visualizar', $MODULOACESSO['usuario'])) { ?>
               <li><a href="index.php?mod=marcas&amp;acao=listarMarcas">• Marcas</a></li>
            <?php } ?>
         </ul>
      </li>
   <?php } ?>

   <?php if (verificaPermissaoAcesso('features_visualizar', $MODULOACESSO['usuario'])) { ?>
      <li class="menu_ul_li">
         <a class="menu_ul_li_a"><i class='fa-icon fas fa-asterisk' aria-hidden="true"></i>Features</a>
         <ul>
            <li class="li-title-mobile">Features</li>
            <li><a href="index.php?mod=features&amp;acao=listarFeatures">• Consulta</a></li>
            <?php if(verificaPermissaoAcesso('features_criar', $MODULOACESSO['usuario'])): ?>
               <li><a href="index.php?mod=features&amp;acao=formFeatures&amp;met=cadastroFeatures">• Cadastro</a></li>
            <?php endif;?>
         </ul>
      </li>
   <?php } ?>

   <?php if (verificaPermissaoAcesso('galeria_visualizar', $MODULOACESSO['usuario'])) { ?>
      <li class="menu_ul_li">
         <a class="menu_ul_li_a"><i class='fa-icon fas fa-images' aria-hidden="true"></i>Galeria</a>
         <ul>
            <li class="li-title-mobile">Galeria</li>
            <li><a href="index.php?mod=galeria&amp;acao=listarGaleria">• Listagem</a></li>
         </ul>
      </li>
   <?php } ?>

   <?php if (verificaPermissaoAcesso('idiomas_visualizar', $MODULOACESSO['usuario'])) { ?>
      <li class="menu_ul_li">
         <a class="menu_ul_li_a"><i class='fa-icon fas fa-globe' aria-hidden="true"></i>Idiomas</a>
         <ul>
            <li class="li-title-mobile">Idiomas</li>
            <li><a href="index.php?mod=idiomas&amp;acao=listarIdiomas">• Consulta</a></li>
            <?php if(verificaPermissaoAcesso('idiomas_criar', $MODULOACESSO['usuario'])): ?>
               <li><a href="index.php?mod=idiomas&amp;acao=formIdiomas&amp;met=cadastroIdiomas">• Cadastro</a></li>
            <?php endif;?>
         </ul>
      </li>
   <?php } ?>

   <?php if (verificaPermissaoAcesso('newsletter_visualizar', $MODULOACESSO['usuario'])) { ?>
      <li class="menu_ul_li">
         <a class="menu_ul_li_a"><i class='fa-icon fas fa-newspaper' aria-hidden="true"></i>Newsletter</a>
         <ul>
            <li class="li-title-mobile">Newsletter</li>
            <li><a href="index.php?mod=newsletter&amp;acao=listarNewsletter">• Consulta</a></li>
         </ul>
      </li>
   <?php } ?>

   <?php if (verificaPermissaoAcesso('marcas_visualizar', $MODULOACESSO['usuario'])) { ?>
      <li class="menu_ul_li">
         <a class="menu_ul_li_a"><i class='fa-icon fas fa-handshake' aria-hidden="true"></i>Marcas</a>
         <ul>
            <li class="li-title-mobile">Marcas</li>
            <li><a href="index.php?mod=marcas&amp;acao=listarMarcas">• Consulta</a></li>
            <?php if(verificaPermissaoAcesso('marcas_criar', $MODULOACESSO['usuario'])): ?>
               <li><a href="index.php?mod=marcas&amp;acao=formMarcas&amp;met=cadastroMarcas">• Cadastro</a></li>
            <?php endif;?>
         </ul>
      </li>
   <?php } ?>

   <?php if (verificaPermissaoAcesso('timeline_visualizar', $MODULOACESSO['usuario'])) { ?>
      <li class="menu_ul_li">
         <a class="menu_ul_li_a"><i class='fa-icon fas fa-hourglass' aria-hidden="true"></i>Timeline</a>
         <ul>
            <li class="li-title-mobile">Timeline</li>
            <li><a href="index.php?mod=timeline&amp;acao=listarTimeline">• Consulta</a></li>
            <?php if(verificaPermissaoAcesso('timeline_criar', $MODULOACESSO['usuario'])): ?>
               <li><a href="index.php?mod=timeline&amp;acao=formTimeline&amp;met=cadastroTimeline">• Cadastro</a></li>
            <?php endif;?>
         </ul>
      </li>
   <?php } ?>

   <?php if (verificaPermissaoAcesso('tratamentos_visualizar', $MODULOACESSO['usuario'])) { ?>
      <li class="menu_ul_li">
         <a class="menu_ul_li_a"><i class='fa-icon fas fa-list' aria-hidden="true"></i>Tratamentos</a>
         <ul>
            <li class="li-title-mobile">Tratamentos</li>
            <li><a href="index.php?mod=tratamentos&amp;acao=listarTratamentos">• Consulta</a></li>
            <?php if(verificaPermissaoAcesso('tratamentos_criar', $MODULOACESSO['usuario'])): ?>
               <li><a href="index.php?mod=tratamentos&amp;acao=formTratamentos&amp;met=cadastroTratamentos">• Cadastro</a></li>
            <?php endif;?>
         </ul>
      </li>
   <?php } ?>

   <?php if (verificaPermissaoAcesso('relatorios_visualizar', $MODULOACESSO['usuario'])) { ?>
      <li class="menu_ul_li">
         <a class="menu_ul_li_a"><i class='fa-icon fas fa-copy' aria-hidden="true"></i>Relatorios</a>
         <ul>
            <li class="li-title-mobile">Relatorios</li>
            <li><a href="index.php?mod=relatorios&amp;acao=listarRelatorios">• Consulta</a></li>
            <?php if(verificaPermissaoAcesso('relatorios_criar', $MODULOACESSO['usuario'])): ?>
               <li><a href="index.php?mod=relatorios&amp;acao=formRelatorios&amp;met=cadastroRelatorios">• Cadastro</a></li>
            <?php endif;?>
         </ul>
      </li>
   <?php } ?>

   <?php if (verificaPermissaoAcesso('seo_visualizar', $MODULOACESSO['usuario'])) { ?>
      <li class="menu_ul_li">
         <a class="menu_ul_li_a"><i class='fa-icon fas fa-bookmark' aria-hidden="true"></i>Seo</a>
         <ul>
            <li class="li-title-mobile">Seo</li>
            <li><a href="index.php?mod=seo&amp;acao=listarSeo">• Consulta</a></li>
            <?php if(verificaPermissaoAcesso('seo_criar', $MODULOACESSO['usuario'])): ?>
               <li><a href="index.php?mod=seo&amp;acao=formSeo&amp;met=cadastroSeo">• Cadastro</a></li>
            <?php endif;?>
         </ul>
      </li>
   <?php } ?>
    
<!-- NAO APAGAR!!! INSERIR OPCAO DE MENU AQUI -->

    <?php if(
              verificaPermissaoAcesso('configuracoes_listagem_usuarios', $MODULOACESSO['usuario']) ||
              verificaPermissaoAcesso('configuracoes_cadastro_usuarios', $MODULOACESSO['usuario']) ||
              verificaPermissaoAcesso('configuracoes_permissao', $MODULOACESSO['usuario'])         ||
              verificaPermissaoAcesso('configuracoes_log', $MODULOACESSO['usuario'])
            ){ ?>

    <li class="menu_ul_li">
        <a class="menu_ul_li_a"><i class="fa-icon fas fa-cog"></i>Configuração</a>
        <ul>
         <li class="li-title-mobile">Configuração</li>
            <?php if( verificaPermissaoAcesso('configuracoes_listagem_usuarios', $MODULOACESSO['usuario']) ){ ?>
              <li><a href="index.php?mod=usuario&acao=listarUsuario">• Listagem Usuários</a></li>
            <?php } ?>
            <?php if( verificaPermissaoAcesso('configuracoes_cadastro_usuarios', $MODULOACESSO['usuario']) ){ ?>
            <li><a href="index.php?mod=usuario&acao=formUsuario&met=novaUsuario">• Cadastro Usuário</a></li>
            <?php } ?>
            <?php if( verificaPermissaoAcesso('configuracoes_permissao', $MODULOACESSO['usuario']) ){ ?>
            <li><a href="index.php?mod=permissao&acao=listarPermissao">• Permissão</a></li>
            <?php } ?>
            <?php if( verificaPermissaoAcesso('integracoes', $MODULOACESSO['usuario']) ){ ?>
            <li><a href="index.php?mod=integracoes&acao=listarIntegracoes">• Integrações</a></li>
            <?php } ?>
            <?php if( verificaPermissaoAcesso('configuracoes_log', $MODULOACESSO['usuario']) ){ ?>
            <li><a href="index.php?mod=log&acao=listarLog">• Log</a></li>
            <?php } ?>
        </ul>
    </li>
    <?php } ?>

  </ul>
  <a href="" class="menu_close"></a>
</aside>
