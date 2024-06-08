<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data['title'] }}</title>
</head>
<body>
    <div
        class="table-responsive"
    >
        <table
            class="table table-primary"
        >
            <thead>
                <tr>
                    <th scope="col">Name </th>
                    <th scope="col">{{ $data['name'] }}</th>
                </tr>
                <tr>
                    <th scope="col">Email </th>
                    <th scope="col">{{ $data['email'] }}</th>
                </tr>
                <tr>
                    <th scope="col">Password </th>
                    <th scope="col">{{ $data['password'] }}</th>
                </tr>
            </thead>
           
        </table>
    </div>
    <a href="{{ $data['url'] }}">Click Here To Login</a>
   <p>Thank You</p> 
</body>
</html>