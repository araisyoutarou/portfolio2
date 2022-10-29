<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/calendar.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">家計簿アプリ</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">ログイン</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">登録</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        ログアウト
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            <div class="button">
                <button onclick="location.href='https:/'">カレンダー</button>
                <button disabled>円グラフ</button>
            </div>
            <h1 class="title">家計簿アプリ</h1>

            <div class="years">
               <th>年を選択</th>
               <select id="yearSelect" name="year" onChange="showCalender()"> 
                  <option value="/?year=2023">2023年</option>
                  <option value="/?year=2022">2022年</option>
                  <option value="/?year=2021">2021年</option>
                  <option value="/?year=2020">2020年</option>
                  <option value="/?year=2019">2019年</option>
                  <option value="/?year=2018">2018年</option>
               </select>
               <th>月を選択</th>
               <select id="monthSelect" name="month" onChange="showCalender()">
                  <option value="&month=year">年間</option>
                  <option value="&month=1">1月</option>
                  <option value="&month=2">2月</option>
                  <option value="&month=3">3月</option>
                  <option value="&month=4">4月</option>
                  <option value="&month=5">5月</option>
                  <option value="&month=6">6月</option>
                  <option value="&month=7">7月</option>
                  <option value="&month=8">8月</option>
                  <option value="&month=9">9月</option>
                  <option value="&month=10">10月</option>
                  <option value="&month=11">11月</option>
                  <option value="&month=12">12月</option>
               </select>

                <div class="chart">
                   <div>
                      <canvas id="allChart"></canvas>
                   </div>
                </div>

                <div class="total">
                    <label class="col-md-2" for="price">支出合計</label>
                    <label class="prices">{{ $prices }}円</label>
                    <label class="col-md-2" for="income">収入合計</label>
                    <label class="prices">{{ $incomes }}円</label>
                </div>
                <script src="{{ asset('js/show_chart.js') }}"></script>
                <script>
                   id = 'allChart';
                   labels = @json($keys);
                   data = @json($counts);
                   make_chart(id,labels,data);
                </script>
        </main>
    </div>
    
    
    
</body>
</html>
