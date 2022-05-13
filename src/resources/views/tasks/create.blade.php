<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script>

    <title>Tasks</title>
</head>

<body>
    <div class="container">
        <h2>New Task</h2>
        <div class="row">
            <div class="col-md-offset-2 col-md-8">
                {!! Form::open(['action' => ['TaskController@create'], 'method' => 'post']) !!}
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>タイトル</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ Form::text('title', '', ['id' => 'title', 'class' => 'form-control']) }}</td>
                        </tr>
                    </tbody>
                </table>
                {{ Form::submit('登録', ['class' => 'btn btn-primary']) }}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</body>

</html>
