<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pronote Ifran - Taux de Présence par Module</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('css/interface.css') }}">
</head>
<body>
    <div class="app">
        <header class="header">
            <div class="title">Pronote Ifran - Taux de Présence </div>
        </header>

        <div class="layout">
            <aside class="sidebar">
                <ul>
                    <li class="menu-item">
                       <a href="/coordinator-interface/{classId?}"><span class="icon">&#128197;</span> Emploi du temps</a>
                            
                        
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('taux_par_classe') }}">
                            <span class="icon">&#128202;</span> Graphiques par Classe
                        </a>
                    </li>
                    <li class="menu-item active">
                        <span class="icon">&#128202;</span> Graphiques par Module
                    </li>
                  
                </ul>
            </aside>

            <main class="main-content">
                <h2>Taux de Présence par Module</h2>

                <canvas id="tauxPresenceModuleChart"></canvas>
            </main>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('tauxPresenceModuleChart').getContext('2d');

        
        const labels = @json(array_keys($tauxPresencesParModule));
        const data = @json(array_values($tauxPresencesParModule));

       
        function getColor(taux) {
            if (taux >= 70) return 'rgba(0, 128, 0, 0.6)'; // Vert foncé
            if (taux >= 50.1) return 'rgba(144, 238, 144, 0.6)'; // Vert clair
            if (taux >= 30.1) return 'rgba(255, 165, 0, 0.6)'; // Orange
            return 'rgba(255, 0, 0, 0.6)'; // Rouge
        }

        const backgroundColors = data.map(taux => getColor(taux));

        const tauxPresenceModuleChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Taux de Présence (%)',
                    data: data,
                    backgroundColor: backgroundColors,
                    borderColor: 'rgba(0, 0, 0, 0.1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
