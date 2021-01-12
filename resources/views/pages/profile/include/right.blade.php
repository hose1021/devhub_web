<div class="mb-2">
    <p class="font-bold text-base text-gray-500 uppercase mb-1">Aktiv grafi</p>
    <div class="border rounded  bg-white">
        <canvas id="myChart" style="width: 100%; height: 8rem" class="px-4 py-5"></canvas>
    </div>
</div>

<div class="border p-2 rounded mb-2">
    <p class="font-medium mb-3">Izləyənlər</p>
    <div class="flex -space-x-2 overflow-hidden p-1">
        @if (count($user->relationships->followers->data) > 0)
            @foreach($user->relationships->followers->data as $follower)
                <img src="{{ $follower->attributes->avatar }}" alt="User profili"
                     class="inline-block h-10 w-10 rounded-full ring-2 ring-gray-300">
            @endforeach
        @else
            <p>Heç kim istifadəçini izləmir</p>
        @endif
    </div>
</div>
<div class="border p-2 rounded">
    <p class="font-medium mb-3">Izlənən</p>
    <div class="flex -space-x-2 overflow-hidden p-1">
        @if (count($user->relationships->followings->data) > 0)
            @foreach($user->relationships->followings->data as $following)
                <img src="{{ $following->attributes->avatar }}" alt="User profili"
                     class="inline-block h-10 w-10 rounded-full ring-2 ring-gray-300">
            @endforeach
        @else
            <p>İstifadəçi heç kimi izləmir</p>
        @endif
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 600);
        gradient.addColorStop(0, "rgba(0, 174, 239, .3)");
        gradient.addColorStop(0.35, "rgba(255, 255, 255, 0)");
        gradient.addColorStop(1, "rgba(255, 255, 255, 0)");
        function randomScalingFactor(){
            return Math.random() * 3;
        }
        const myLineChart = new Chart(ctx, {
            type: 'line',
            data: {

                labels: [{{ implode(', ', array_fill(0, 31, "`Paylasma`")) }}],
                datasets: [{
                    backgroundColor: gradient,
                    borderColor: '#095c79',
                    label: 'Paylasma',
                    data: [
                        {{ implode(', ', $count) }}
                    ],
                    fill: true,
                }]
            },
            options: {
                tooltips: {enabled: false},
                hover: {mode: null},
                legend: {
                    display: false
                },
                elements: {
                    point: {
                        radius: 0
                    }
                },
                responsive: false,
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        display: false,
                    }],
                    yAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            display: false,
                            min: 0,
                            max: 5,
                            stepSize: 1
                        }
                    }]
                },
            }
        });
    </script>
@endpush

