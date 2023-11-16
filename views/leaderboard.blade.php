<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
</head>
<body>
    <div className="leaderboard-conatainer">
        <div class="table">
            <table>
                <tr>
                    <td><h3>Name</h3></td> <td><h3>Highscore</h3></td>
                </tr>
                @forelse($leaderboard as $entry)
                <tr>
                    <td>{{$entry->Name}}</td> <td>{{$entry->Score}}</td>
                </tr>
                @empty
                
                @endforelse
            </table>
        </div>

        <a href="home">Back to Main Menu</a>
    </div>
</body>
</html>