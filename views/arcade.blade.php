<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arcade</title>
</head>
<body>
    <div className="arcade-container">
        <a href="home">Quit to Main Menu</a> </br>
        <h3>Page of an Arcade Game</h3>
        <p>Lives: {{$lives}}</p> </br>
        <p>Score: {{$score}}</p> </br>
        <p>Question text: {{$question}}</p> </br>
        <p>
            <form action="{{ route('arcade') }}" method="POST">
                @csrf
                <input type="text" name="user_input">
                <button type="submit">Submit</button>
            </form>
        </p>
    </div>
</body>
</html>