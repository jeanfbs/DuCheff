<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="O Macarrão Du Cheff é o melhor estabelecimento
    de massas da região de Uberlândia, com pratos únicos feitos com amor e dedicação
    para nossos clientes.">
    <meta name="author" content="Jean Fabricio">
    <title>@yield('title')</title>

    <link rel="shortcut icon" href="{{url('favicon.ico')}}" type="image/x-icon">
    <link href="{{url('plugins/bootstrap/bootstrap.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{url('css/shop-homepage.css')}}" rel="stylesheet">
    <link href="{{url('css/footer.css')}}" rel="stylesheet">
    <link href="{{url('css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

  <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <img class="pull-left" src="{{url('/img/logo.png')}}" alt="Logo DuCheff" width="40">
                <a class="navbar-brand" href="{{url('/')}}">DuCheff</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="{{url('cardapio')}}">Cardápio</a>
                    </li>
                    <li>
                        <a href="{{url('download-app')}}">Pedidos Online</a>
                    </li>
                    <li>
                        <a href="{{url('contato')}}">Contato</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                <li><a href="{{url('login')}}"><i class="fa fa-sign-in"></i> Logar</a></li>
              </ul>
            </div>

            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container" id="conteudo">
        @yield('content')
    </div>
    <!-- /.container -->
    <script src="{{url('plugins/jquery/jquery-2.1.0.min.js')}}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{url('plugins/bootstrap/bootstrap.min.js')}}"></script>
    <!-- All functions for this theme + document.ready processing -->

</body>

</html>
