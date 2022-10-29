window.make_chart = function make_chart(id, labels, data)
{
    var ctx = document.getElementById(id).getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                label: '月別支出割合',
                data: data,
                backgroundColor: [
                    // 赤
                    'rgba(255, 99, 132, 0.2)',
                    // 青
                    'rgba(54, 162, 235, 0.2)',
                    // 黄
                    'rgba(255, 206, 86, 0.2)',
                    // 緑
                    'rgba(75, 192, 192, 0.2)',
                    // 紫
                    'rgba(153, 102, 255, 0.2)',
                    // 橙
                    'rgba(255, 159, 64, 0.2)',
                    // 紺
                    'rgba(51, 99, 132, 0.2)',
                    // 桃
                    'rgba(255, 102, 255, 0.2)',
                    // 灰
                    'rgba(220, 220, 220, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(51, 99, 132, 1)',
                    'rgba(255, 102, 255, 1)',
                    'rgba(220, 220, 220, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
        }
    });
};