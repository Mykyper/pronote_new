<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Parent</title>
    <style>
        /* =========================
           Styles conservés
        ========================= */
        header {
            width: 100%;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(90deg, #1e3c72, #2a5298);
            color: white;
            font-family: 'Calibri', Arial, Helvetica, sans-serif;
            font-size: 26px;
            font-weight: bold;
            letter-spacing: 1px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        header h1 {
            margin: 0;
            transition: transform 0.2s ease, letter-spacing 0.2s ease;
        }
        header h1:hover {
            transform: scale(1.05);
            letter-spacing: 2px;
        }
        body {
            font-family: 'Calibri', Arial, Helvetica, sans-serif;
            background: #f5f5f5;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding-top: 80px;
        }
        form {
            max-width: 400px;
            margin: 40px auto;
            padding: 28px 32px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 7px 18px rgba(0, 0, 0, 0.25);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        form:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 22px rgba(0, 0, 0, 0.28);
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
        form input[type="submit"] {
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
        form input[type="submit"]:hover {
            background-color: #1e3c72;
            transform: translateY(-2px);
        }
        .success-message {
            text-align: center;
            color: green;
            margin-bottom: 15px;
            font-weight: 500;
        }
        .error-message {
            text-align: center;
            color: red;
            margin-bottom: 15px;
            font-weight: 500;
        }
        @media (max-width: 480px) {
            form {
                max-width: 90%;
                padding: 24px 20px;
            }
            form h1 {
                font-size: 22px;
            }
            form input, form input[type="submit"] {
                font-size: 15px;
                padding: 11px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Ajouter un parent d'élève</h1>
    </header>

    <form id="add-parent-form">
        <h1>Ajouter un Parent</h1>

        <div id="message"></div>

        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required>

        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Ajouter">
    </form>

    <script>
        const form = document.getElementById('add-parent-form');
        const messageDiv = document.getElementById('message');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const nom = document.getElementById('nom').value;
            const prenom = document.getElementById('prenom').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            messageDiv.innerHTML = '';
            messageDiv.className = '';

            try {
                const response = await fetch('/api/parents', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ nom, prenom, email, password })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    messageDiv.className = 'success-message';
                    messageDiv.innerText = data.message;
                    form.reset();
                } else {
                    messageDiv.className = 'error-message';
                    if (data.errors) {
                        messageDiv.innerText = Object.values(data.errors).flat().join(' ');
                    } else {
                        messageDiv.innerText = data.message || 'Erreur lors de l\'ajout du parent.';
                    }
                }
            } catch (error) {
                messageDiv.className = 'error-message';
                messageDiv.innerText = 'Erreur de connexion au serveur';
                console.error(error);
            }
        });
    </script>
</body>
</html>
