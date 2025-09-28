<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pronote Ifran - Taux de Présence par Élève</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('css/interface.css') }}">
    <style>
        .tabs {
            margin: 20px 0;
        }
        .tab {
            padding: 10px 20px;
            margin: 0 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #f9f9f9;
            cursor: pointer;
        }
        .tab.active {
            background: #ddd;
        }
        .graph-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="app">
        <header class="header">
            <div class="title">Pronote Ifran - Taux de Présence par Élève</div>
        </header>

        <div class="layout">
            <aside class="sidebar">
                <ul>
                    <li class="menu-item">
                        <a href="{{ route('emploi_du_temps') }}">
                            <span class="icon">&#128197;</span> Emploi du temps
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('graphiques.taux_par_classe') }}">
                            <span class="icon">&#128202;</span> Graphiques par Classe
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('graphiques.taux_par_module') }}">
                            <span class="icon">&#128202;</span> Graphiques par Module
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('absences') }}">
                            <span class="icon">&#128100;</span> Absences
                        </a>
                    </li>
                </ul>
            </aside>

            <main class="main-content">
                <div class="tabs">
                    @foreach ($classes as $class)
                        <a href="{{ route('coord-inter', ['classId' => $class->id]) }}">
                            <button class="tab {{ $classe && $classe->id == $class->id ? 'active' : '' }}">
                                {{ $class->niveau }} {{ $class->specialite }}
                            </button>
                        </a>
                    @endforeach
                </div>

                @if ($classe)
                    <h2>Taux de Présence pour les Élèves de {{ $classe->niveau }} {{ $classe->specialite }}</h2>

                    <div class="graph-container">
                        <canvas id="tauxPresenceEleveChart"></canvas>
                    </div>

                    <script>
                        const ctx = document.getElementById('tauxPresenceEleveChart').getContext('2d');

                        const labels = @json(array_keys($tauxPresencesParEleve));
                        const data = @json(array_values($tauxPresencesParEleve));

                        function getColor(taux) {
                            if (taux >= 70) return 'rgba(0, 128, 0, 0.6)'; // Vert foncé
                            if (taux >= 50.1) return 'rgba(144, 238, 144, 0.6)'; // Vert clair
                            if (taux >= 30.1) return 'rgba(255, 165, 0, 0.6)'; // Orange
                            return 'rgba(255, 0, 0, 0.6)'; // Rouge
                        }

                        const backgroundColors = data.map(taux => getColor(taux));

                        const tauxPresenceEleveChart = new Chart(ctx, {
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
                @endif
            </main>
        </div>
    </div>
</body>
</html>
