<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Élève</title>
    <style>
        /* =========================
           Police générale
        ========================= */
        body {
            font-family: 'Calibri', Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
            background-color: #f5f5f5;
        }

        /* =========================
           Header
        ========================= */
        header {
            width: 100%;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(90deg, #1e3c72, #2a5298);
            color: white;
            font-size: 26px;
            font-weight: bold;
            letter-spacing: 1px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        header h1 {
            transition: transform 0.2s ease, letter-spacing 0.2s ease;
        }

        header h1:hover {
            transform: scale(1.05);
            letter-spacing: 2px;
        }

        /* =========================
           Conteneur du formulaire
        ========================= */
        main {
            padding-top: 100px; /* espace pour le header */
        }

        form {
            max-width: 400px;
            margin: 20px auto 60px;
            padding: 28px 32px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 7px 18px rgba(0, 0, 0, 0.25);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        form:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 22px rgba(0,0,0,0.28);
        }

        /* =========================
           Titre du formulaire
        ========================= */
        form h1 {
            text-align: center;
            margin-bottom: 22px;
            color: #222;
            font-size: 26px;
            font-weight: bold;
        }

        /* =========================
           Labels
        ========================= */
        form label {
            display: block;
            margin: 10px 0 5px;
            color: #333;
            font-weight: 500;
            font-size: 14.5px;
        }

        /* =========================
           Champs input
        ========================= */
        form input[type="text"],
        form input[type="email"],
        form input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 7px;
            font-size: 14.5px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        form input:focus {
            outline: none;
            border-color: #2a5298;
            box-shadow: 0 0 5px rgba(42,82,152,0.5);
        }

        /* =========================
           Bouton
        ========================= */
        form button {
            width: 100%;
            padding: 12px;
            background-color: #2a5298;
            color: white;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        form button:hover {
            background-color: #1e3c72;
            transform: translateY(-2px);
        }

        /* =========================
           Messages de succès
        ========================= */
        .success-message {
            text-align: center;
            color: green;
            margin-bottom: 15px;
            font-weight: 500;
        }

        /* =========================
           Select custom
        ========================= */
        .form-select-wrapper {
            position: relative;
            width: 100%;
            margin-bottom: 15px;
        }

        .form-select-wrapper select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            width: 100%;
            padding: 12px 40px 12px 12px;
            border: 1px solid #ccc;
            border-radius: 7px;
            font-size: 14.5px;
            cursor: pointer;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            background: white;
        }

        .form-select-wrapper select:focus {
            outline: none;
            border-color: #2a5298;
            box-shadow: 0 0 5px rgba(42,82,152,0.5);
        }

        .form-select-wrapper::after {
            content: '▾';
            font-size: 18px;
            color: #2a5298;
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            pointer-events: none;
        }

        /* =========================
           Responsive
        ========================= */
        @media (max-width: 480px) {
            form {
                max-width: 90%;
                padding: 24px 20px;
            }

            form h1 {
                font-size: 22px;
            }

            form input, form button, .form-select-wrapper select {
                font-size: 15px;
                padding: 11px;
            }
        }
    </style>
</head>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Élève</title>
    <style>
        body {
            font-family: 'Calibri', Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
            background-color: #f5f5f5;
        }

        header {
            width: 100%;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(90deg, #1e3c72, #2a5298);
            color: white;
            font-size: 26px;
            font-weight: bold;
            letter-spacing: 1px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        header h1 {
            transition: transform 0.2s ease, letter-spacing 0.2s ease;
        }

        header h1:hover {
            transform: scale(1.05);
            letter-spacing: 2px;
        }

        main {
            padding-top: 100px;
        }

        form {
            max-width: 400px;
            margin: 20px auto 60px;
            padding: 28px 32px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 7px 18px rgba(0, 0, 0, 0.25);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        form:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 22px rgba(0,0,0,0.28);
        }

        form h1 {
            text-align: center;
            margin-bottom: 22px;
            color: #222;
            font-size: 26px;
            font-weight: bold;
        }

        form label {
            display: block;
            margin: 10px 0 5px;
            color: #333;
            font-weight: 500;
            font-size: 14.5px;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 7px;
            font-size: 14.5px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        form input:focus {
            outline: none;
            border-color: #2a5298;
            box-shadow: 0 0 5px rgba(42,82,152,0.5);
        }

        form button {
            width: 100%;
            padding: 12px;
            background-color: #2a5298;
            color: white;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        form button:hover {
            background-color: #1e3c72;
            transform: translateY(-2px);
        }

        .success-message, .error-message {
            text-align: center;
            margin-bottom: 15px;
            font-weight: 500;
        }
        .success-message { color: green; }
        .error-message { color: red; }

        .form-select-wrapper {
            position: relative;
            width: 100%;
            margin-bottom: 15px;
        }

        .form-select-wrapper select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            width: 100%;
            padding: 12px 40px 12px 12px;
            border: 1px solid #ccc;
            border-radius: 7px;
            font-size: 14.5px;
            cursor: pointer;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            background: white;
        }

        .form-select-wrapper select:focus {
            outline: none;
            border-color: #2a5298;
            box-shadow: 0 0 5px rgba(42,82,152,0.5);
        }

        .form-select-wrapper::after {
            content: '▾';
            font-size: 18px;
            color: #2a5298;
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            pointer-events: none;
        }

        @media (max-width: 480px) {
            form { max-width: 90%; padding: 24px 20px; }
            form h1 { font-size: 22px; }
            form input, form button, .form-select-wrapper select { font-size: 15px; padding: 11px; }
        }
    </style>
</head>
<body>
    <header>
        <h1>Ajouter un élève</h1>
    </header>

    <main>
        <p id="successMessage" class="success-message" style="display:none;"></p>
        <p id="errorMessage" class="error-message" style="display:none;"></p>

        <form id="addStudentForm">
            <h1>Ajouter un Élève</h1>

            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>

            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>

            <label for="parent">Parent:</label>
            <div class="form-select-wrapper">
                <select id="parent" name="parent_id" required></select>
            </div>

            <label for="classe">Classe:</label>
            <div class="form-select-wrapper">
                <select id="classe" name="classe_id" required></select>
            </div>

            <button type="submit">Ajouter</button>
        </form>
    </main>

    <script>
        // Charger parents et classes depuis l'API
        async function loadFormData() {
            try {
                const response = await fetch('/api/students/create');
                const data = await response.json();

                const parentSelect = document.getElementById('parent');
                data.parents.forEach(parent => {
                    const option = document.createElement('option');
                    option.value = parent.id;
                    option.textContent = `${parent.nom} ${parent.prenom}`;
                    parentSelect.appendChild(option);
                });

                const classeSelect = document.getElementById('classe');
                data.classes.forEach(classe => {
                    const option = document.createElement('option');
                    option.value = classe.id;
                    option.textContent = `${classe.niveau} - ${classe.specialité}`;
                    classeSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Erreur lors du chargement des données:', error);
                document.getElementById('errorMessage').textContent = 'Impossible de charger les données';
                document.getElementById('errorMessage').style.display = 'block';
            }
        }

        loadFormData();

        // Soumission du formulaire via API
        document.getElementById('addStudentForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = {
                nom: document.getElementById('nom').value,
                prenom: document.getElementById('prenom').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                parent_id: document.getElementById('parent').value,
                classe_id: document.getElementById('classe').value,
            };

            try {
                const response = await fetch('/api/students', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });

                const result = await response.json();

                if (response.ok) {
                    document.getElementById('successMessage').textContent = result.message;
                    document.getElementById('successMessage').style.display = 'block';
                    document.getElementById('errorMessage').style.display = 'none';
                    this.reset();
                } else {
                    let message = result.message || 'Erreur lors de l\'ajout';
                    if(result.errors) {
                        message = Object.values(result.errors).flat().join(' ');
                    }
                    document.getElementById('errorMessage').textContent = message;
                    document.getElementById('errorMessage').style.display = 'block';
                    document.getElementById('successMessage').style.display = 'none';
                }
            } catch (error) {
                console.error('Erreur:', error);
                document.getElementById('errorMessage').textContent = 'Erreur serveur';
                document.getElementById('errorMessage').style.display = 'block';
                document.getElementById('successMessage').style.display = 'none';
            }
        });
    </script>
</body>
</html>
