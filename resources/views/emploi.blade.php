<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Créer l'Emploi du Temps</title>
<link rel="stylesheet" href="{{ asset('css/interface.css') }}">
<link rel="stylesheet" href="{{ asset('css/emploi.css') }}">
<style>
    .timetable-container {
        overflow-x: auto;
        margin-top: 20px;
    }
    table.timetable {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        border-radius: 5px;
        overflow: hidden;
    }
    table.timetable th,
    table.timetable td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }
    table.timetable th {
        background-color: #007bff;
        color: white;
    }
    select, input[type="date"] {
        width: 90%;
        padding: 5px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }
    button {
        margin-top: 15px;
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        background-color: #28a745;
        color: white;
        cursor: pointer;
    }
    button:hover {
        background-color: #218838;
    }
</style>
</head>
<body>
<header class="header">
    <div class="title">Pronote Ifran</div>
    <div class="role">Coordinateur</div>
</header>

<div class="layout">
    <aside class="sidebar">
        <ul>
            <li class="menu-item active"><span class="icon">&#128197;</span> Emploi du temps</li>
            <li class="menu-item"><span class="icon">&#128202;</span> Graphiques</li>
            <li class="menu-item"><span class="icon">&#128100;</span> Absences</li>
        </ul>
    </aside>

    <main class="main-content">
        <h1>Créer l'Emploi du Temps</h1>
        <form id="schedule-form">
            @csrf
            <div class="form-section">
                <label for="class">Classe :</label>
                <select id="class" name="class_id" required style="width: 150px;">
                    @foreach ($classes as $classe)
                        <option value="{{ $classe->id }}">{{ $classe->niveau }} - {{ $classe->specialite }}</option>
                    @endforeach
                </select>
            </div>

            <div class="timetable-container">
                <table class="timetable">
                    <thead>
                        <tr>
                            <th>Jour</th>
                            <th>Date</th>
                            <th>Module Matin</th>
                            <th>Enseignant Matin</th>
                            <th>Module Soir</th>
                            <th>Enseignant Soir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(['lundi','mardi','mercredi','jeudi','vendredi'] as $day)
                        <tr>
                            <td>{{ ucfirst($day) }}</td>
                            <td><input type="date" name="schedule[{{ $day }}][day]" required></td>
                            <td>
                                <select name="schedule[{{ $day }}][morning_module_id]">
                                  
                                    @foreach ($modules as $module)
                                        <option value="{{ $module->id }}">{{ $module->nom }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="schedule[{{ $day }}][morning_teacher_id]">
                                   
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->nom }} {{ $teacher->prenom }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="schedule[{{ $day }}][evening_module_id]">
                                  
                                    @foreach ($modules as $module)
                                        <option value="{{ $module->id }}">{{ $module->nom }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="schedule[{{ $day }}][evening_teacher_id]">
                                    
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->nom }} {{ $teacher->prenom }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button type="submit">Enregistrer l'Emploi du Temps</button>
        </form>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.getElementById("schedule-form").addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const classId = formData.get("class_id");

    const schedule = ['lundi','mardi','mercredi','jeudi','vendredi'].map(day => ({
        day: formData.get(`schedule[${day}][day]`),
        morning_module_id: formData.get(`schedule[${day}][morning_module_id]`) || null,
        morning_teacher_id: formData.get(`schedule[${day}][morning_teacher_id]`) || null,
        evening_module_id: formData.get(`schedule[${day}][evening_module_id]`) || null,
        evening_teacher_id: formData.get(`schedule[${day}][evening_teacher_id]`) || null,
    }));

    try {
        const response = await axios.post("{{ route('api.schedule.store') }}", {
            class_id: classId,
            schedule: schedule
        });

        if (response.data.success) {
            alert("✅ Emploi du temps enregistré avec succès !");
            // Optionnel : reset du formulaire
            e.target.reset();
        } else {
            alert("❌ " + (response.data.message || "Erreur lors de l'enregistrement"));
        }
    } catch (err) {
        console.error(err);
        alert("❌ Erreur API !");
    }
});
</script>
</body>
</html>
