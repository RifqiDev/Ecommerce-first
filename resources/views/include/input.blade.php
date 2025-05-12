<!DOCTYPE html>
    <html>
    <head>
        <title>Pendaftaran</title>
    </head>
    <body>
    <a href="{{url('/')}}">Ke Halaman Utama</a>

        <h1>Pendaftaran Hari</h1>
        <form method="post" action="{{url('foto')}}">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            foto
    <br><input type="file" name="image" value="{{ isset($image) ? $image : '' }}">
        <br>
        <br>

        <input type="submit" name="Submit" value="Submit">
    </form>
    </body>
    </html>
