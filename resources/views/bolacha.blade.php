<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Site Exemplo</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <!-- Importação do Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Inclusão do JavaScript -->
    <script src="{{ asset('js/scriptsprodutos.js') }}"></script>
    <script src="{{ asset('js/scripttema.js') }}"></script>


    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <style>
        .product-card {
            background-color: #e0e0e0;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 50px;
            /* Espaçamento entre as linhas */
            max-width: 335px;
            /* Largura máxima dos cards */
        }

        .product-card img {
            width: 85%;
            height: 250px;
            /* Ajuste a altura da imagem */
            object-fit: cover;
            /* Ajusta a imagem para cobrir o card */
        }

        .product-price {
            color: red;
            font-size: 24px;
            margin: 10px 0;
        }

        .product-name,
        .market-name {
            font-size: 16px;
            color: #333;
        }

        .product-card p {
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
        }

        .product-review-label {
            margin-left: 5px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="images/logo_cb.png" alt="Logo" class="logo-image">
            </a>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('mercados') }}">Mercados</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" aria-current="page" href="{{ route('produtos') }}">
                            Produtos
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('cadastro_produto') }}">Cadastrar Produto</a></li>
                        </ul>
                    </li>
                </ul>
                 @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert" id="success-alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

                <script>
                    setTimeout(function() {
                        var alert = document.getElementById('success-alert');
                        if (alert) {
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                        }
                    }, 5000); // 5000ms = 5 segundos
                </script>
                @endif
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert" id="error-alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <script>
                    setTimeout(function() {
                        var alert = document.getElementById('error-alert');
                        if (alert) {
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                        }
                    }, 5000); // 5000ms = 5 segundos
                </script>
                @endif
                        </ul>
                    </li>
                </ul>
            </div>

            <!-- Conta -->
            <a href="{{ route('register') }}" class="navbar-brand ms-auto">
                <img src="{{ asset('images/conta_tcc.png') }}" alt="Conta" class="conta-image">
            </a>

        </div>
    </nav>

    <!-- Seção de Produtos em Destaque -->
    <div class="container mt-5">
        <h2 class="text-start mb-4">Produtos em destaque</h2>

        <!-- Barra de Pesquisa -->
        <!-- Barra de Pesquisa -->
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <label for="name_product" class="form-label">Nome do Produto:</label>
                    <input type="text" id="produtoDigitado" class="form-control mb-2" placeholder="Pesquisar produto..." onkeyup="pesquisar()">
                    <br>
                    <label for="name_market" class="form-label">Nome do Mercado:</label>
                    <input type="text" id="mercadoDigitado" class="form-control" placeholder="Pesquisar mercado..." onkeyup="pesquisar()">
                </div>
            </div>
            <br>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ordenacaoSelect">Ordenar produtos</label>
                        <select class="form-select" id="ordenacaoSelect" aria-label="Ordenação dos produtos" onchange="ordenarProdutos()">
                            <option value="0" selected>Selecione um filtro:</option>
                            <option value="1">Mais barato ao mais caro</option>
                            <option value="2">Mais caro ao mais barato</option>
                            <option value="3">Mais recente ao mais antigo</option>
                            <option value="4">Mais antigo ao mais recente</option>
                            <option value="5">Número de avaliações</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>

        <!-- Produtos -->
        <div class="row" id="produtos-container">
            <div class="col-lg-4 col-md-4">
                <div class="product-card">
                    <img src="images/pr_bolacha.png" alt="Imagem do Produto 1">
                    <div class="product-info">
                        <form action="{{ route('favoritar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_produto" value="25">
                            <input type="hidden" name="id_mercado" value="1">
                            <button class="btn btn-danger favorite-button">
                                <i class="far fa-heart heart-empty"></i>
                                <i class="fas fa-heart heart-filled" style="display:none;"></i>
                            </button>
                        </form>
                        <br>
                        <p class="product-name">Biscoito Cream Cracker Adria 170g</p> <br>
                        @php
                        // apresentando a media de preços
                        $precomedio = App\Models\ProdutosCaracteristicas::where('id_mercado', 1) // ID do mercado
                        ->where('id_produto', 25) // ID do produto
                        ->avg('preco');
                        $data = App\Models\ProdutosCaracteristicas::where('id_mercado', 1) // ID do mercado
                        ->where('id_produto', 25) // ID do produto
                        ->latest('updated_at')
                        ->value('updated_at');

                        // Ajustar o timezone
                        if ($data) {


                        $data = \Carbon\Carbon::parse($data)->setTimezone('America/Sao_Paulo');
                        }
                        @endphp
                        <p class="product-price">R$ {{ number_format($precomedio, 2, ',', '.') }}</p>
                        <p class="market-name">Mercado Noemia</p>
                        <br>
                        <p class="product-date">Ultima atualização de preço: {{ $data ? $data->format('d/m/Y H:i:s') : 'Data não disponível' }}</p>
                        <br>
                        <br>
                        <p class="product-review-label">Avalie a veracidade do preço do produto:</p>
                        <form action="{{ route('avaliacao_produto') }}" class="d-inline" method="POST">
                            <input type="hidden" name="id_produto" value="25"> <!-- ID do produto -->
                            <input type="hidden" name="id_mercado" value="1"> <!-- ID do mercado -->
                            @csrf
                            <div class="input-group input-group-sm">
                                <select name="avaliacao_preco" class="form-select" aria-label="Default select example">
                                    <option value="Correto">Correto</option>
                                    <option value="Incorreto">Incorreto</option>
                                </select>
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="bi bi-search">Registrar</i> <br>
                                </button>
                                @php
                                // Contando as avaliações
                                $correto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Correto')
                                ->where('id_mercado', 1) // ID do mercado
                                ->where('id_produto', 25) // ID do produto
                                ->count();

                                $incorreto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Incorreto')
                                ->where('id_mercado', 1) // ID do mercado
                                ->where('id_produto', 25) // ID do produto
                                ->count();
                                @endphp
                                <h6 class="mt-4">Quantidade de Avaliações:</h6>
                                <p id="product-quantity" class="text-success">O preço está correto: <strong>{{ $correto }}</strong></p>
                                <p class="text-danger">O preço está incorreto: <strong>{{ $incorreto }}</strong></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="product-card">
                    <img src="images/pr_bolacha.png" alt="Imagem do Produto 2">
                    <div class="product-info">
                        <form action="{{ route('favoritar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_produto" value="25">
                            <input type="hidden" name="id_mercado" value="2">
                            <button class="btn btn-danger favorite-button">
                                <i class="far fa-heart heart-empty"></i>
                                <i class="fas fa-heart heart-filled" style="display:none;"></i>
                            </button>
                        </form>
                        <br>
                        <p class="product-name">Biscoito Cream Cracker Adria 170g</p> <br>
                        @php
                        // apresentando a media de preços
                        $precomedio = App\Models\ProdutosCaracteristicas::where('id_mercado', 2) // ID do mercado
                        ->where('id_produto', 25) // ID do produto
                        ->avg('preco');
                        $data = App\Models\ProdutosCaracteristicas::where('id_mercado', 2) // ID do mercado
                        ->where('id_produto', 25) // ID do produto
                        ->latest('updated_at')
                        ->value('updated_at');

                        // Ajustar o timezone
                        if ($data) {


                        $data = \Carbon\Carbon::parse($data)->setTimezone('America/Sao_Paulo');
                        }
                        @endphp
                        <p class="product-price">R$ {{ number_format($precomedio, 2, ',', '.') }}</p>
                        <p class="market-name">Mercado Tietê</p>
                        <br>
                        <p class="product-date">Ultima atualização de preço: {{ $data ? $data->format('d/m/Y H:i:s') : 'Data não disponível' }}</p>
                        <br>
                        <br>
                        <p class="product-review-label">Avalie a veracidade do preço do produto:</p>
                        <form action="{{ route('avaliacao_produto') }}" class="d-inline" method="POST">
                            <input type="hidden" name="id_produto" value="25"> <!-- ID do produto -->
                            <input type="hidden" name="id_mercado" value="2"> <!-- ID do mercado -->
                            @csrf
                            <div class="input-group input-group-sm">
                                <select name="avaliacao_preco" class="form-select" aria-label="Default select example">
                                    <option value="Correto">Correto</option>
                                    <option value="Incorreto">Incorreto</option>
                                </select>
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="bi bi-search">Registrar</i> <br>
                                </button>
                                @php
                                // Contando as avaliações
                                $correto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Correto')
                                ->where('id_mercado', 2) // ID do mercado
                                ->where('id_produto', 25) // ID do produto
                                ->count();

                                $incorreto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Incorreto')
                                ->where('id_mercado', 2) // ID do mercado
                                ->where('id_produto', 25) // ID do produto
                                ->count();
                                @endphp
                                <h6 class="mt-4">Quantidade de Avaliações:</h6>
                                <p id="product-quantity" class="text-success">O preço está correto: <strong>{{ $correto }}</strong></p>
                                <p class="text-danger">O preço está incorreto: <strong>{{ $incorreto }}</strong></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="product-card">
                    <img src="images/pr_bolacha.png" alt="Imagem do Produto 3">
                    <div class="product-info">
                        <form action="{{ route('favoritar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_produto" value="25">
                            <input type="hidden" name="id_mercado" value="3">
                            <button class="btn btn-danger favorite-button">
                                <i class="far fa-heart heart-empty"></i>
                                <i class="fas fa-heart heart-filled" style="display:none;"></i>
                            </button>
                        </form>
                        <br>
                        <p class="product-name">Biscoito Cream Cracker Adria 170g</p> <br>
                        @php
                        // apresentando a media de preços
                        $precomedio = App\Models\ProdutosCaracteristicas::where('id_mercado', 3) // ID do mercado
                        ->where('id_produto', 25) // ID do produto
                        ->avg('preco');
                        $data = App\Models\ProdutosCaracteristicas::where('id_mercado', 3) // ID do mercado
                        ->where('id_produto', 25) // ID do produto
                        ->latest('updated_at')
                        ->value('updated_at');

                        // Ajustar o timezone
                        if ($data) {


                        $data = \Carbon\Carbon::parse($data)->setTimezone('America/Sao_Paulo');
                        }
                        @endphp
                        <p class="product-price">R$ {{ number_format($precomedio, 2, ',', '.') }}</p>
                        <p class="market-name">Mercado Economix</p>
                        <br>
                        <p class="product-date">Ultima atualização de preço: {{ $data ? $data->format('d/m/Y H:i:s') : 'Data não disponível' }}</p>
                        <br>
                        <br>
                        <p class="product-review-label">Avalie a veracidade do preço do produto:</p>
                        <form action="{{ route('avaliacao_produto') }}" class="d-inline" method="POST">
                            <input type="hidden" name="id_produto" value="25"> <!-- ID do produto -->
                            <input type="hidden" name="id_mercado" value="3"> <!-- ID do mercado -->
                            @csrf
                            <div class="input-group input-group-sm">
                                <select name="avaliacao_preco" class="form-select" aria-label="Default select example">
                                    <option value="Correto">Correto</option>
                                    <option value="Incorreto">Incorreto</option>
                                </select>
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="bi bi-search">Registrar</i> <br>
                                </button>
                                @php
                                // Contando as avaliações
                                $correto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Correto')
                                ->where('id_mercado', 3) // ID do mercado
                                ->where('id_produto', 25) // ID do produto
                                ->count();

                                $incorreto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Incorreto')
                                ->where('id_mercado', 3) // ID do mercado
                                ->where('id_produto', 25) // ID do produto
                                ->count();
                                @endphp
                                <h6 class="mt-4">Quantidade de Avaliações:</h6>
                                <p id="product-quantity" class="text-success">O preço está correto: <strong>{{ $correto }}</strong></p>
                                <p class="text-danger">O preço está incorreto: <strong>{{ $incorreto }}</strong></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="product-card">
                    <img src="images/pr_bolacha.png" alt="Imagem do Produto 4">
                    <div class="product-info">
                        <form action="{{ route('favoritar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_produto" value="25">
                            <input type="hidden" name="id_mercado" value="4">
                            <button class="btn btn-danger favorite-button">
                                <i class="far fa-heart heart-empty"></i>
                                <i class="fas fa-heart heart-filled" style="display:none;"></i>
                            </button>
                        </form>
                        <br>
                        <p class="product-name">Biscoito Cream Cracker Adria 170g</p> <br>
                        @php
                        // apresentando a media de preços
                        $precomedio = App\Models\ProdutosCaracteristicas::where('id_mercado', 4) // ID do mercado
                        ->where('id_produto', 25) // ID do produto
                        ->avg('preco');
                        $data = App\Models\ProdutosCaracteristicas::where('id_mercado', 4) // ID do mercado
                        ->where('id_produto', 25) // ID do produto
                        ->latest('updated_at')
                        ->value('updated_at');

                        // Ajustar o timezone
                        if ($data) {


                        $data = \Carbon\Carbon::parse($data)->setTimezone('America/Sao_Paulo');
                        }
                        @endphp
                        <p class="product-price">R$ {{ number_format($precomedio, 2, ',', '.') }}</p>
                        <p class="market-name">Mercado Atacadinho</p>
                        <br>
                        <p class="product-date">Ultima atualização de preço: {{ $data ? $data->format('d/m/Y H:i:s') : 'Data não disponível' }}</p>
                        <br>
                        <br>
                        <p class="product-review-label">Avalie a veracidade do preço do produto:</p>
                        <form action="{{ route('avaliacao_produto') }}" class="d-inline" method="POST">
                            <input type="hidden" name="id_produto" value="25"> <!-- ID do produto -->
                            <input type="hidden" name="id_mercado" value="4"> <!-- ID do mercado -->
                            @csrf
                            <div class="input-group input-group-sm">
                                <select name="avaliacao_preco" class="form-select" aria-label="Default select example">
                                    <option value="Correto">Correto</option>
                                    <option value="Incorreto">Incorreto</option>
                                </select>
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="bi bi-search">Registrar</i> <br>
                                </button>
                                @php
                                // Contando as avaliações
                                $correto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Correto')
                                ->where('id_mercado', 4) // ID do mercado
                                ->where('id_produto', 25) // ID do produto
                                ->count();

                                $incorreto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Incorreto')
                                ->where('id_mercado', 4) // ID do mercado
                                ->where('id_produto', 25) // ID do produto
                                ->count();
                                @endphp
                                <h6 class="mt-4">Quantidade de Avaliações:</h6>
                                <p id="product-quantity" class="text-success">O preço está correto: <strong>{{ $correto }}</strong></p>
                                <p class="text-danger">O preço está incorreto: <strong>{{ $incorreto }}</strong></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="product-card">
                    <img src="images/pr_bolacha2.png" alt="Imagem do Produto 5">
                    <div class="product-info">
                        <form action="{{ route('favoritar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_produto" value="26">
                            <input type="hidden" name="id_mercado" value="1">
                            <button class="btn btn-danger favorite-button">
                                <i class="far fa-heart heart-empty"></i>
                                <i class="fas fa-heart heart-filled" style="display:none;"></i>
                            </button>
                        </form>
                        <br>
                        <p class="product-name">Biscoito Bauducco Cream Cracker 200g</p>
                        @php
                        // apresentando a media de preços
                        $precomedio = App\Models\ProdutosCaracteristicas::where('id_mercado', 1) // ID do mercado
                        ->where('id_produto', 26) // ID do produto
                        ->avg('preco');
                        $data = App\Models\ProdutosCaracteristicas::where('id_mercado', 1) // ID do mercado
                        ->where('id_produto', 26) // ID do produto
                        ->latest('updated_at')
                        ->value('updated_at');

                        // Ajustar o timezone
                        if ($data) {


                        $data = \Carbon\Carbon::parse($data)->setTimezone('America/Sao_Paulo');
                        }
                        @endphp
                        <p class="product-price">R$ {{ number_format($precomedio, 2, ',', '.') }}</p>
                        <p class="market-name">Mercado Noemia</p>
                        <br>
                        <p class="product-date">Ultima atualização de preço: {{ $data ? $data->format('d/m/Y H:i:s') : 'Data não disponível' }}</p>
                        <br>
                        <br>
                        <p class="product-review-label">Avalie a veracidade do preço do produto:</p>
                        <form action="{{ route('avaliacao_produto') }}" class="d-inline" method="POST">
                            <input type="hidden" name="id_produto" value="26"> <!-- ID do produto -->
                            <input type="hidden" name="id_mercado" value="1"> <!-- ID do mercado -->
                            @csrf
                            <div class="input-group input-group-sm">
                                <select name="avaliacao_preco" class="form-select" aria-label="Default select example">
                                    <option value="Correto">Correto</option>
                                    <option value="Incorreto">Incorreto</option>
                                </select>
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="bi bi-search">Registrar</i> <br>
                                </button>
                                @php
                                // Contando as avaliações
                                $correto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Correto')
                                ->where('id_mercado', 1) // ID do mercado
                                ->where('id_produto', 26) // ID do produto
                                ->count();

                                $incorreto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Incorreto')
                                ->where('id_mercado', 1) // ID do mercado
                                ->where('id_produto', 26) // ID do produto
                                ->count();
                                @endphp
                                <h6 class="mt-4">Quantidade de Avaliações:</h6>
                                <p id="product-quantity" class="text-success">O preço está correto: <strong>{{ $correto }}</strong></p>
                                <p class="text-danger">O preço está incorreto: <strong>{{ $incorreto }}</strong></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="product-card">
                    <img src="images/pr_bolacha2.png" alt="Imagem do Produto 6">
                    <div class="product-info">
                        <form action="{{ route('favoritar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_produto" value="26">
                            <input type="hidden" name="id_mercado" value="2">
                            <button class="btn btn-danger favorite-button">
                                <i class="far fa-heart heart-empty"></i>
                                <i class="fas fa-heart heart-filled" style="display:none;"></i>
                            </button>
                        </form>
                        <br>
                        <p class="product-name">Biscoito Bauducco Cream Cracker 200g</p>
                        @php
                        // apresentando a media de preços
                        $precomedio = App\Models\ProdutosCaracteristicas::where('id_mercado', 2) // ID do mercado
                        ->where('id_produto', 26) // ID do produto
                        ->avg('preco');
                        $data = App\Models\ProdutosCaracteristicas::where('id_mercado', 2) // ID do mercado
                        ->where('id_produto', 26) // ID do produto
                        ->latest('updated_at')
                        ->value('updated_at');

                        // Ajustar o timezone
                        if ($data) {


                        $data = \Carbon\Carbon::parse($data)->setTimezone('America/Sao_Paulo');
                        }
                        @endphp
                        <p class="product-price">R$ {{ number_format($precomedio, 2, ',', '.') }}</p>
                        <p class="market-name">Mercado Tietê</p>
                        <br>
                        <p class="product-date">Ultima atualização de preço: {{ $data ? $data->format('d/m/Y H:i:s') : 'Data não disponível' }}</p>
                        <br>
                        <br>
                        <p class="product-review-label">Avalie a veracidade do preço do produto:</p>
                        <form action="{{ route('avaliacao_produto') }}" class="d-inline" method="POST">
                            <input type="hidden" name="id_produto" value="26"> <!-- ID do produto -->
                            <input type="hidden" name="id_mercado" value="2"> <!-- ID do mercado -->
                            @csrf
                            <div class="input-group input-group-sm">
                                <select name="avaliacao_preco" class="form-select" aria-label="Default select example">
                                    <option value="Correto">Correto</option>
                                    <option value="Incorreto">Incorreto</option>
                                </select>
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="bi bi-search">Registrar</i> <br>
                                </button>
                                @php
                                // Contando as avaliações
                                $correto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Correto')
                                ->where('id_mercado', 2) // ID do mercado
                                ->where('id_produto', 26) // ID do produto
                                ->count();

                                $incorreto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Incorreto')
                                ->where('id_mercado', 2) // ID do mercado
                                ->where('id_produto', 26) // ID do produto
                                ->count();
                                @endphp
                                <h6 class="mt-4">Quantidade de Avaliações:</h6>
                                <p id="product-quantity" class="text-success">O preço está correto: <strong>{{ $correto }}</strong></p>
                                <p class="text-danger">O preço está incorreto: <strong>{{ $incorreto }}</strong></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="product-card">
                    <img src="images/pr_bolacha2.png" alt="Imagem do Produto 7">
                    <div class="product-info">
                        <form action="{{ route('favoritar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_produto" value="26">
                            <input type="hidden" name="id_mercado" value="3">
                            <button class="btn btn-danger favorite-button">
                                <i class="far fa-heart heart-empty"></i>
                                <i class="fas fa-heart heart-filled" style="display:none;"></i>
                            </button>
                        </form>
                        <br>
                        <p class="product-name">Biscoito Bauducco Cream Cracker 200g</p>
                        @php
                        // apresentando a media de preços
                        $precomedio = App\Models\ProdutosCaracteristicas::where('id_mercado', 3) // ID do mercado
                        ->where('id_produto', 26) // ID do produto
                        ->avg('preco');
                        $data = App\Models\ProdutosCaracteristicas::where('id_mercado', 3) // ID do mercado
                        ->where('id_produto', 26) // ID do produto
                        ->latest('updated_at')
                        ->value('updated_at');

                        // Ajustar o timezone
                        if ($data) {


                        $data = \Carbon\Carbon::parse($data)->setTimezone('America/Sao_Paulo');
                        }
                        @endphp
                        <p class="product-price">R$ {{ number_format($precomedio, 2, ',', '.') }}</p>
                        <p class="market-name">Mercado Economix</p>
                        <br>
                        <p class="product-date">Ultima atualização de preço: {{ $data ? $data->format('d/m/Y H:i:s') : 'Data não disponível' }}</p>
                        <br>
                        <br>
                        <p class="product-review-label">Avalie a veracidade do preço do produto:</p>
                        <form action="{{ route('avaliacao_produto') }}" class="d-inline" method="POST">
                            <input type="hidden" name="id_produto" value="26"> <!-- ID do produto -->
                            <input type="hidden" name="id_mercado" value="3"> <!-- ID do mercado -->
                            @csrf
                            <div class="input-group input-group-sm">
                                <select name="avaliacao_preco" class="form-select" aria-label="Default select example">
                                    <option value="Correto">Correto</option>
                                    <option value="Incorreto">Incorreto</option>
                                </select>
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="bi bi-search">Registrar</i> <br>
                                </button>
                                @php
                                // Contando as avaliações
                                $correto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Correto')
                                ->where('id_mercado', 3) // ID do mercado
                                ->where('id_produto', 26) // ID do produto
                                ->count();

                                $incorreto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Incorreto')
                                ->where('id_mercado', 3) // ID do mercado
                                ->where('id_produto', 26) // ID do produto
                                ->count();
                                @endphp
                                <h6 class="mt-4">Quantidade de Avaliações:</h6>
                                <p id="product-quantity" class="text-success">O preço está correto: <strong>{{ $correto }}</strong></p>
                                <p class="text-danger">O preço está incorreto: <strong>{{ $incorreto }}</strong></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="product-card">
                    <img src="images/pr_bolacha2.png" alt="Imagem do Produto 8">
                    <div class="product-info">
                        <form action="{{ route('favoritar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_produto" value="26">
                            <input type="hidden" name="id_mercado" value="4">
                            <button class="btn btn-danger favorite-button">
                                <i class="far fa-heart heart-empty"></i>
                                <i class="fas fa-heart heart-filled" style="display:none;"></i>
                            </button>
                        </form>
                        <br>
                        <p class="product-name">Biscoito Bauducco Cream Cracker 200g</p>
                        @php
                        // apresentando a media de preços
                        $precomedio = App\Models\ProdutosCaracteristicas::where('id_mercado', 4) // ID do mercado
                        ->where('id_produto', 26) // ID do produto
                        ->avg('preco');
                        $data = App\Models\ProdutosCaracteristicas::where('id_mercado', 4) // ID do mercado
                        ->where('id_produto', 26) // ID do produto
                        ->latest('updated_at')
                        ->value('updated_at');

                        // Ajustar o timezone
                        if ($data) {


                        $data = \Carbon\Carbon::parse($data)->setTimezone('America/Sao_Paulo');
                        }
                        @endphp
                        <p class="product-price">R$ {{ number_format($precomedio, 2, ',', '.') }}</p>
                        <p class="market-name">Mercado Atacadinho</p>
                        <br>
                        <p class="product-date">Ultima atualização de preço: {{ $data ? $data->format('d/m/Y H:i:s') : 'Data não disponível' }}</p>
                        <br>
                        <br>
                        <p class="product-review-label">Avalie a veracidade do preço do produto:</p>
                        <form action="{{ route('avaliacao_produto') }}" class="d-inline" method="POST">
                            <input type="hidden" name="id_produto" value="26"> <!-- ID do produto -->
                            <input type="hidden" name="id_mercado" value="4"> <!-- ID do mercado -->
                            @csrf
                            <div class="input-group input-group-sm">
                                <select name="avaliacao_preco" class="form-select" aria-label="Default select example">
                                    <option value="Correto">Correto</option>
                                    <option value="Incorreto">Incorreto</option>
                                </select>
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="bi bi-search">Registrar</i> <br>
                                </button>
                                @php
                                // Contando as avaliações
                                $correto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Correto')
                                ->where('id_mercado', 4) // ID do mercado
                                ->where('id_produto', 26) // ID do produto
                                ->count();

                                $incorreto = App\Models\AvaliacaoProduto::where('avaliacao_preco', 'Incorreto')
                                ->where('id_mercado', 4) // ID do mercado
                                ->where('id_produto', 26) // ID do produto
                                ->count();
                                @endphp
                                <h6 class="mt-4">Quantidade de Avaliações:</h6>
                                <p id="product-quantity" class="text-success">O preço está correto: <strong>{{ $correto }}</strong></p>
                                <p class="text-danger">O preço está incorreto: <strong>{{ $incorreto }}</strong></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    <br>
    <br>
    <br>
    <footer class="bg-dark text-light pt-5 pb-4" style="font-family: 'Montserrat', sans-serif;">
        <div class="container">
            <div class="row align-items-start">
                <!-- Logo -->
                <div class="col-12 col-sm-6 col-md-2 mb-4 d-flex justify-content-center justify-content-md-start">
                    <img src="images/logo_cb.png" alt="Logo" class="img-fluid">
                </div>

                <!-- Sobre Nós -->
                <div class="col-12 col-sm-6 col-md-3 mb-4">
                    <h5 class="footer-title text-uppercase text-primary">Sobre Nós</h5>
                    <p>Nosso compromisso é comparar e oferecer as melhores opções de produtos, unindo qualidade e preços acessíveis para ajudar você a fazer a melhor escolha.</p>
                </div>

                <!-- Links do Site -->
                <div class="col-12 col-sm-6 col-md-2 mb-4">
                    <h5 class="footer-title text-uppercase text-primary">Links do Site</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-light">Início</a></li>
                        <li><a href="{{ route('mercados') }}" class="text-light">Mercados</a></li>
                        <li><a href="{{ route('produtos') }}" class="text-light">Produtos</a></li>
                        <li><a href="{{ route('cadastro_produto') }}" class="text-light">Cadastrar Produto</a></li>
                    </ul>
                </div>

                <!-- Contato -->
                <div class="col-12 col-sm-6 col-md-3 mb-4">
                    <h5 class="footer-title text-uppercase text-primary">Contato</h5>
                    <p class="mb-1"><i class="fas fa-envelope me-2"></i>cbcompare.bem@gmail.com</p>
                </div>

                <!-- Redes Sociais -->
                <div class="col-12 col-sm-6 col-md-2 mb-4">
                    <h5 class="footer-title text-uppercase text-primary">Siga-nos</h5>
                    <a href="https://www.instagram.com/cbcompare.bem/" class="text-light me-2">
                        <i class="fab fa-instagram fa-2x"></i>
                    </a>
                </div>
            </div>

            <hr class="bg-light">

            <div class="row">
                <div class="col-12 col-md-8 mb-2 mb-md-0">
                    <p>© 2024 <span class="text-primary fw-bold">Compare Bem</span></p>
                </div>
                <div class="col-12 col-md-4 text-center text-md-end">
                    <p>Desenvolvido por <span class="text-primary fw-bold">Jobson, Samuel, João Vitor e Raphaela</span></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>