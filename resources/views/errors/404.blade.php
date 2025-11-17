<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .error-container {
            text-align: center;
            padding: 2rem;
        }

        .error-code {
            font-size: 6rem;
            font-weight: bold;
            color: #6c757d;
        }

        .error-message {
            font-size: 1.5rem;
            color: #495057;
            margin-bottom: 1rem;
        }

        .back-link {
            color: #007bff;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-code">404</div>
        <div class="error-message">Page Not Found</div>
        <a href="{{ url('/dashboard') }}" class="back-link">Go to Dashboard</a>
    </div>
</body>

</html>
