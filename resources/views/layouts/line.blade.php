<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>LineClone</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- viewport meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
    .title{
        margin-top:30px;
        margin-bottom:20px;
        text-align:center;
        font-family:bold;
        color: #778899;
    }
    .sub-title{
        margin-top:10px;
        margin-bottom:10px;
    }
    .FollowBtn {
        height:40px;
        width:60px;
    }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/line">LineClone</a>
    <div class="navbar-brand">{{Auth::user()->name}}さんがログイン中</div>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="ナビゲーションの切替">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/line/users">Users<span class="sr-only">(現位置)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/line/mypage">MyPage</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/line/logout">Logout</a>
            </li>
            </ul>
        </div>
    </nav>
    <div>
    @yield('content')
    </div>
    <!-- jQuery、Popper.js、Bootstrap JS -->

</body>
</html>