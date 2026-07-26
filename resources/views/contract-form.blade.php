<!doctype html>
<html lang="en">
    <head>
        @include("partials.favicons")
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Contract Generator</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 40px;
                color: #222;
            }
            form {
                max-width: 520px;
            }
            label {
                display: block;
                margin-top: 16px;
                font-weight: 600;
            }
            input {
                width: 100%;
                padding: 10px 12px;
                margin-top: 6px;
                border: 1px solid #ccc;
                border-radius: 6px;
                font-size: 14px;
            }
            button {
                margin-top: 20px;
                padding: 10px 18px;
                border: 0;
                border-radius: 6px;
                background: #1f2937;
                color: #fff;
                font-size: 14px;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <h1>Generate Contract PDF</h1>
        <form method="POST" action="{{ url('/generate-pdf') }}">
            @csrf
            <label for="organization">Organization</label>
            <input id="organization" name="organization" type="text" required>

            <label for="cr_copy">CR Copy</label>
            <input id="cr_copy" name="cr_copy" type="text" required>

            <label for="name">Name</label>
            <input id="name" name="name" type="text" required>

            <label for="hall">Hall</label>
            <input id="hall" name="hall" type="text" required>

            <button type="submit">Generate PDF</button>
        </form>
    </body>
</html>
