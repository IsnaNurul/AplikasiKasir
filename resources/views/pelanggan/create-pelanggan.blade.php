<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="/pelanggan/add" method="post">
        @csrf
        <table>
            <h2>Akun Pelanggan</h2>
            <tr>
                <td>username :</td>
                <td><input type="text" name="username" id=""></td>
            </tr>
            <tr>
                <td>password :</td>
                <td><input type="password" name="password" id=""></td>
            </tr>
        </table>
        <table>
            <h2>Data Diri</h2>
            <tr>
                <td>Nama Pelanggan :</td>
                <td><input type="text" name="nama_pelanggan" id=""></td>
            </tr>
            <tr>
                <td>Alamat :</td>
                <td><textarea name="alamat" id="" cols="30" rows="10"></textarea></td>
            </tr>
            <tr>
                <td>No Telepon :</td>
                <td><input type="text" name="no_telepon" id=""></td>
            </tr>
            <tr>
                <td><input type="submit" value="Simpan Data"></td>
            </tr>
        </table>
    </form>
</body>
</html>