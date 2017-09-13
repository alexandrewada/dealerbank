<!DOCTYPE html>
<html lang="en">
  <head>

    <script type="text/javascript">
      var base_url = '<?=base_url();?>';
    </script>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  

    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />


    <title>Dealer Factoring</title>

    <!-- jQuery -->
    <script src="<?=base_url('public/vendors/jquery/dist/jquery.min.js');?>"></script>

    <!-- Toast -->
    <script src="<?=base_url('public/js/template/toast.js');?>"></script>


    <!-- Bootstrap -->
    <link href="<?=base_url('public/vendors/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?=base_url('public/vendors/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">

    <!-- NProgress -->
    <link href="<?=base_url('public/vendors/nprogress/nprogress.css');?>" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="<?=base_url('public/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css');?>" rel="stylesheet"/>

    <!-- Custom Theme Style -->
    <link href="<?=base_url('public/css/template/custom2.css?v=203923');?>" rel="stylesheet">

    <link href="<?=base_url('public/css/template/template.css?v=203');?>" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
  <!--           <div class="navbar nav_title" style="border: 0; margin-bottom: 30px;">
               <img class='center-block img-responsive' src='<?=base_url('public/images/logo.png');?>'/>
            </div> -->

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="<?=FOTO_PERFIL;?>" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Bem vindo,</span>
                <h2><?=$nome?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <div style="margin-bottom: 10px;"></div>
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Menu</h3>
                <ul class="nav side-menu">



                  <li>
                    <a href='<?=base_url("");?>'><i class="fa fa-circle"></i> Principal</a>
                  </li>

                    <?if(in_array($perfil,array(1,8)) == true):?>
               		  <li><a><i class="fa fa-group"></i> Clientes <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="<?=base_url('clientes/cadastrar');?>">Cadastrar</a></li>
                        <li><a href="<?=base_url('clientes/gerenciar');?>">Pesquisar</a></li>
                      </ul>
                    </li>            
                    <?endif;?>

                    <?if(in_array($perfil,array(1,8)) == true):?>
               		  <li><a><i class="fa fa-user"></i> Usuários <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="<?=base_url('usuarios/cadastrar');?>">Cadastrar</a></li>
                        <li><a href="<?=base_url('usuarios/gerenciar');?>">Pesquisar</a></li>
                      </ul>
                    </li>            
                    <?endif;?>

                    <?if(in_array($perfil,array(1,8)) == true):?>
                    <li><a><i class="fa fa-newspaper-o"></i> Borderôs <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="<?=base_url('bordero/gerenciar');?>">Pesquisar</a></li>
                      </ul>
                    </li>            
                    <?endif;?>

                    <?if(in_array($perfil,array(1,8)) == true):?>
                    <li><a><i class="fa fa-newspaper-o"></i> Títulos <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="<?=base_url('titulo/gerenciar');?>">Pesquisar</a></li>
                      </ul>
                    </li>            
                    <?endif;?>


               
                   
                </ul>
              </div>


            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
         <!--    <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div> -->
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?=FOTO_PERFIL;?>" alt=""><?=$nome;?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="<?=base_url('principal/sair');?>"><i class="fa fa-sign-out pull-right"></i> Sair</a></li>
                  </ul>
                </li>

               <!--  <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">6</span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <span class="image"><img src="<?=$_SESSION['foto'];?>" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?=$_SESSION['foto'];?>" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?=$_SESSION['foto'];?>" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="<?=$_SESSION['foto'];?>" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li> -->
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div>
            <div class="page-title">
              <!-- <div class="title_left">
                <h3><?=$titulo;?></h3>
              </div> -->
            </div>
            <div class="clearfix"></div>
            <div id='conteudo' class='row'>
              <?=$contents;?>
            </div>
          </div>


        </div>
        <!-- /page content -->

        <!-- footer content -->
       <!--  <footer>
          <div class="pull-right">
            Apple Planet
          </div>
          <div class="clearfix"></div>
        </footer> -->
        <!-- /footer content -->
      </div>
    </div>

    <!-- Bootstrap -->
    <script src="<?=base_url();?>public/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?=base_url();?>public/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?=base_url();?>public/vendors/nprogress/nprogress.js"></script>
    <!-- jQuery custom content scroller -->
    <script src="<?=base_url();?>public/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?=base_url();?>public/js/template/custom.min.js"></script>

    <script src="<?=base_url();?>public/js/template/cep.js"></script>


    <!-- funcoes template -->
    <script src="<?=base_url('public/js/template/funcoes.js');?>"></script>

    <script src="http://cdn.jsdelivr.net/momentjs/latest/moment.min.js" type="text/javascript"></script>

    <!-- datapicker -->
    <script src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

     <!-- AjaxPost -->
    <script src="<?=base_url('public/js/template/ajaxPost.js');?>"></script>

    <!-- Mask -->
    <script src="<?=base_url();?>public/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>

    <script type="text/javascript">
      $(document).ready(function(){
         $(":input").inputmask({greedy: false,placeholder:""});
      });
    </script>

    <!--mask-->



<div id='modalAjax' class="modal bs-example-modal-lg" tabindex="-1" role="dialog" >
  <div class="modal-dialog modal-lg" role="document">
    <div id='modalAjax_html' class="modal-content">
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>

  </div>
</div>


  </body>
</html>