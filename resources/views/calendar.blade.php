@extends('layouts.app')
@section('content')
<div class="button">
   <button class="btn btn-secondary btn-lg" disabled>カレンダー</button>
   <input type="submit" class="btn btn-primary btn-lg" value="円グラフ" onClick="chart()">
</div>
<div class="years">
   <th>年を選択</th>
   <select class="text-light bg-success" id="yearSelect" name="year" onChange="showCalender()">
      @foreach ($yearSelection as $key => $value)
         <option value="/?year={{$value}}">{{ $value }}年</option>
      @endforeach
   </select>
   <th>月を選択</th>
   <select class="text-light bg-success" id="monthSelect" name="month" onChange="showCalender()">
      <option value="&month=year">年間</option>
      @foreach ($monthSelection as $key => $value)
         <option value="&month={{$value}}">{{ $key }}月</option>
      @endforeach
   </select>
   <script>
      function showCalender() {
         var yearSelect = document.getElementById("yearSelect").value;
         var monthSelect = document.getElementById("monthSelect").value;
         let ymSelect = yearSelect + monthSelect;
         location.href = ymSelect;
      }
      document.getElementById("yearSelect").querySelector("option[value='/?year={{ $year }}']").setAttribute("selected", "selected");
      document.getElementById("monthSelect").querySelector("option[value='&month={{ $month }}']").setAttribute("selected", "selected");
      
      function chart() {
         var paramstr = document.location.search;
         document.location.href = "/chart"+paramstr;
       }
   </script>
</div>
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="color">
            <div class="blue">青色＝支出</div>
            <div class="red">赤色＝収入</div>
         </div>
         <div class="calendar_create">
            @foreach ($calendar as $hoge)
            　{{ $hoge->getTitle() }}
            　{!! $hoge->render() !!}
            @endforeach
         </div>
      </div>
   </div>
</div>
@endsection