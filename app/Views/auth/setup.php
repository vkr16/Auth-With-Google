<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="public/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="public/css/output.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,700;1,400&display=swap" rel="stylesheet">

    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="public/libs/JQuery/jquery.js"></script>
    <script src="public/libs/Notiflix/notiflix-aio-3.2.5.min.js"></script>
    <title>Pendaftaran Pengguna - AkuOnline</title>
</head>

<body>

    </style>

    <div class="w-full h-auto md:max-w-sm md:mx-auto">
        <!-- <img src="public/img/secure.jpg" alt=""> -->
        <div class="mx-6 mt-4">
            <h1 class="text-4xl font-Poppins mb-2">Info Pengguna</h1>
            <h2 class="text-slate-900">Lengkapi informasi pengguna berikut untuk melanjutkan pendaftaran.</h2>


            <form class="mt-6">
                <div class="input-group">
                    <label for="nameField" class="text-lg mb-2">Nama Pengguna</label>
                    <input required readonly value="<?= esc($pending['name']) ?>" type="text" name="name" id="nameField" class="border rounded-lg w-full h-10 outline-none px-4 py-2 bg-slate-100">
                </div>
                <div class="input-group mt-4">
                    <label for="emailField" class="text-lg mb-2">Email</label>
                    <input required readonly value="<?= esc($pending['email']) ?>" type="text" name="email" id="emailField" class="border rounded-lg w-full h-10 outline-none px-4 py-2 bg-slate-100">
                </div>
                <div class="input-group mt-4">
                    <label for="surnameField" class="text-lg mb-2">Alias / Nama Panggilan <small class="text-xs">(Opsional)</small></label>
                    <input type="text" name="surname" id="surnameField" class="border rounded-lg w-full h-10 outline-none px-4 py-2 focus:ring focus:ring-cyan-500">
                </div>
                <div class="input-group mt-4">
                    <label for="passwordField" class="text-lg mb-2">Kata sandi</label>
                    <input required type="password" name="password" id="passwordField" class="border rounded-lg w-full h-10 outline-none px-4 py-2 focus:ring focus:ring-cyan-500">
                </div>

                <button type="button" class="mt-6 w-full h-10 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-md px-3 py-1 text-white text-center font-ProductSans self-center scale-100 active:scale-90 transition-all duration-75" onclick="submitRegForm()">Selesai</button>
            </form>
        </div>
    </div>


    <script>
        function submitRegForm() {


            var name = $('input[name="name"]').val()
            var email = $('input[name="email"]').val()
            var surname = $('input[name="surname"]').val()
            var password = $('input[name="password"]').val()

            if (surname != '' && password != '') {
                Notiflix.Block.standard('body', 'Harap tunggu...')
                $.post("register", {
                    name: name,
                    email: email,
                    surname: surname,
                    password: password,
                    uid: '<?= esc($pending['uid']) ?>'
                }).done(function(data) {
                    setTimeout(() => {
                        location.replace('user');
                    }, "2500")
                })
            }
        }

        // Notiflix Library Init

        Notiflix.Block.init({});
        Notiflix.Notify.init({});
    </script>
</body>

</html>