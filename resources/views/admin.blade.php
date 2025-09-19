<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Pronote IFRAN</title>
    <style>
        /* =========================
           Police générale
        ========================== */
        body {
            font-family: 'Calibri', Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        /* =========================
           Header
        ========================== */
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
           Main
        ========================== */
        main {
            padding: 100px 20px 20px;
            display: flex;
            justify-content: center;
        }

        /* =========================
           Container des boutons
        ========================== */
        .admin-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 100%;
            max-width: 400px;
        }

        .admin-container a {
            text-decoration: none;
        }

        .admin-button {
    display: block;
    text-align: center;
    padding: 15px 20px;
    background: linear-gradient(135deg, #1e3c72, #2a5298, #4a90e2);
    color: white;
    font-size: 18px;
    font-weight: bold;
    border-radius: 50px; /* arrondi pill */
    box-shadow: 0 6px 15px rgba(0,0,0,0.25);
    transition: all 0.3s ease;
}

.admin-button:hover {
    transform: translateY(-4px) scale(1.03);
    box-shadow: 0 10px 20px rgba(0,0,0,0.3);
    background: linear-gradient(135deg, #2a5298, #4a90e2, #1e3c72);
}


        /* Responsive */
        @media (max-width: 480px) {
            .admin-button {
                font-size: 16px;
                padding: 12px 15px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin - Pronote IFRAN</h1>
    </header>

    <main>
        <div class="admin-container">
            <a href="{{ route('parents.create') }}">
                <div class="admin-button">Ajouter un Parent</div>
            </a>
            <a href="{{ route('students.create') }}">
                <div class="admin-button">Ajouter un Élève</div>
            </a>
            <a href="{{ route('users.create') }}">
                <div class="admin-button">Ajouter un Utilisateur</div>
            </a>
        </div>
    </main>
</body>
</html>
