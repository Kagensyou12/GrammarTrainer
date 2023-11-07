<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Round</title>
</head>
<body>
    <div className="round-container">
        <a href="home">Quit to Main Menu</a> </br>
        <h3>{{$difficulty}} Round Game</h3>
        <p>Round: {{$round}}/10</p> </br>
        <p>Score: {{$score}}</p> </br>
        <p>Question text: {{$question}}</p> </br>
        <p>{{$message}}</p> </br>
        <p>
            <form action="{{ route('round') }}" method="POST">
                @csrf
                <input type="text" name="user_input">
                <button type="submit">Submit</button>
            </form>
        </p>
    </div>
</body>
</html>