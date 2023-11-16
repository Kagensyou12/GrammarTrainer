<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arcade</title>
</head>
<body>
    <div className="arcade-over-container">
        <h3>{{$message}}</h3>
        <h1>You got Score: {{$score}}</h1>
        
        <form method="post" action="{{ route('save-score') }}">
            @csrf
            <label for="name">Enter your name:</label>
            <input type="text" id="name" name="name" placeholder="Max 5 characters" maxlength="5" required>
            <input type="hidden" name="score" value="{{ $score }}">
            <button type="submit">Submit Score</button>
        </form>
        <a href="home">Back to Main Menu</a>
    </div>
</body>
</html>