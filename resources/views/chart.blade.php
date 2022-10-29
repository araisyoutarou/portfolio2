@extends('layouts.app')
@section('content')
<div class="button">
   <input type="submit" class="btn btn-primary btn-lg" value="カレンダー" onClick="calendar()">
   <button class="btn btn-secondary btn-lg"disabled>円グラフ</button>
</div>
<div class="years">
   <th>年を選択</th>
   <select class="text-light bg-success" id="yearSelect" name="year" onChange="showChart()"> 
      @foreach ($yearSelection as $key => $value)
         <option value="/chart?year={{$value}}">{{ $value }}年</option>
      @endforeach
   </select>
   <th>月を選択</th>
   <select class="text-light bg-success" id="monthSelect" name="month" onChange="showChart()">
      <option value="&month=year">年間</option>
      @foreach ($monthSelection as $key => $value)
         <option value="&month={{$value}}">{{ $key }}月</option>
      @endforeach
   </select>
   <script>
      function showChart() {
         var yearSelect = document.getElementById("yearSelect").value;
         var monthSelect = document.getElementById("monthSelect").value;
         let ymSelect = yearSelect + monthSelect;
         location.href = ymSelect;
      }
      document.getElementById("yearSelect").querySelector("option[value='/chart?year={{ $year }}']").setAttribute("selected", "selected");
      document.getElementById("monthSelect").querySelector("option[value='&month={{ $month }}']").setAttribute("selected", "selected");
      
      function calendar() {
         var paramstr = document.location.search;
         document.location.href = "/"+paramstr;
       }
   </script>
   <div class="chartTotal">
      <div class="summary">
         <label  for="price">支出合計</label>
         <label class="chart_prices">{{ $prices }}円</label>
      </div>
      <div class="summary">
         <label  for="income">収入合計</label>
         <label class="chart_prices">{{ $incomes }}円</label>
      </div>
   </div>
   <div class="content">
      <div>
         <label class="message">{{ $message }}</label>
         <canvas class="allChart" id="allChart"></canvas>
      </div>
   </div>
</div>

<script>
   id = 'allChart';
   labels = @json($keys);
   data = @json($counts);
   make_chart(id,labels,data);
</script>

@endsection