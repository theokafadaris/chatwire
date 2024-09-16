<!-- resources/views/bible/pdf.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Book of {{ $book }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .chapter {
            margin-bottom: 30px;
            page-break-inside: avoid; 
        }

        .chapter-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .entry {
            margin-bottom: 15px;
        }

        .entry p {
            margin: 0;
        }
    </style>
</head>
<body>
    <h1>The Book of {{ $book }}</h1>

    @foreach ($chapters as $chapterNumber => $entries)
        <div class="chapter">
            <div class="chapter-title">Chapter {{ $chapterNumber }}</div>
            @foreach ($entries as $entry)
                <div class="entry">
                    <p><strong>Bible Verse:</strong> {{ $entry['bible_verse'] }}</p>
                    <p><strong>#:</strong> {{ $entry['text'] }}</p>
                </div>
            @endforeach
        </div>
    @endforeach
</body>
</html>
