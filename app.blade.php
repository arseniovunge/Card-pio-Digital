<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Painel Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 220px;
            background: #212529;
            color: white;
            padding: 20px;
            height: 100vh;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            margin: 12px 0;
            padding: 8px 10px;
            border-radius: 4px;
        }
        .sidebar a:hover {
            background: #343a40;
        }
        .sidebar i {
            margin-right: 8px;
        }
        .main {
            flex-grow: 1;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .topbar {
            background: white;
            padding: 15px 25px;
            border-bottom: 1px solid #ddd;
        }
        footer {
            background: #f8f9fa;
            text-align: center;
            font-size: 0.85rem;
            padding: 12px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>

<div class="d-flex" style="flex-grow: 1;">
    <div class="sidebar">
        <div class="text-center mb-4">
            <i class="bi bi-receipt-cutoff fs-1 text-primary"></i>
            <h5 class="mt-2">Cardápio Digital</h5>
        </div>

        <a href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="{{ route('categorias.index') }}"><i class="bi bi-folder"></i> Categorias</a>
        <a href="#"><i class="bi bi-egg-fried"></i> Itens</a>
        <a href="#"><i class="bi bi-grid-3x3-gap"></i> Mesas</a>
        <a href="#"><i class="bi bi-person-badge"></i> Administradores</a>
        <a href="{{ route('logout') }}"><i class="bi bi-box-arrow-right"></i> Sair</a>
    </div>

    <div class="main">
        <div class="topbar">
            <strong>Olá, Admin</strong>
        </div>

        <div class="content p-4">
            @yield('content')
        </div>

        <footer>
            &copy; {{ date('Y') }} Cardápio Digital Todos os direitos reservados. Powered by <strong>Mó Cardápio</strong>.
        </footer>
    </div>
</div>

</body>
</html>
