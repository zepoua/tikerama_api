<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande d'accès à l'API</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #DBE0EE85, #120A864D, rgba(238, 10, 10, 0.308)), url('/images/back.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            display: flex;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            height: auto; /* Removed fixed height */
        }
        .logo-section {
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width: 50%; /* Limite la section du logo à 50% de la largeur */
            max-width: 50%; /* Assure que la section du logo n'excède pas 50% */
        }
        .company-description-wrapper {
            width: 0; /* Début de l'animation avec une largeur de 0 */
            animation: typing 3s steps(50, end) forwards; /* Effet de frappe */
            overflow: hidden;
            white-space: nowrap;
        }
        .company-description {
            font-size: 18px;
            color: black;
            font-weight: bold;
            margin-top: 10px;
            width: 100%; /* S'étend pour couvrir tout le texte */
            word-wrap: break-word; /* Permet au texte de passer à la ligne */
        }
        @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }

        .form-section {
            width: 50%; /* Occupe le reste de la largeur disponible */
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow-y: auto; /* Allow scrolling if necessary */
        }
        .form-section h2 {
            color: #000000;
            margin-bottom: 30px;
            margin-top:20px;
        }
        form {
            width: 100%;
        }
        .form-group {
            margin-bottom: 15px;
            width: 100%;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #000000;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-group input:focus, .form-group textarea:focus {
            border-color: #007bff;
            outline: none;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        .btn {
            background-color: #4D0A0A;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            width: 100%;
        }
        .btn:hover {
            background-color: #683030;
        }

        .message-box {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            width: 100%;
            box-sizing: border-box;
        }

        .message-box.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message-box.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

    </style>
</head>
<body>
    <div class="container" style="background-color: #E4EBF369">
        <div class="logo-section">
            <div>
                <span></span>
            </div>
            <div style="background-color: white; width: 80%; height: 130px; border-radius: 50%; display: flex; justify-content: center; align-items: center; margin-bottom: 20px;">
                <img src="/images/logo.png" alt="Logo de l'entreprise" style="max-width: 95%; height: auto;">
            </div>
            <div class="company-description-wrapper">
                <p class="company-description">Votre partenaire pour gérer vos événements.</p>
            </div>
        </div>
        <div class="form-section">
            <h2>Demande d'accès à l'API</h2>

            @if(session('success'))
                <div class="message-box success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="message-box error">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{route('request_access')}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>
                <div class="form-group">
                    <label for="entreprise">Entreprise</label>
                    <input type="text" id="entreprise" name="entreprise">
                </div>
                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="ville">Ville</label>
                    <input type="text" id="ville" name="ville" required>
                </div>
                <div class="form-group">
                    <label for="adresse">Adresse</label>
                    <textarea id="adresse" name="adresse" required></textarea>
                </div>
                <button type="submit" class="btn">Envoyer</button>
            </form>
        </div>
    </div>
</body>
</html>
