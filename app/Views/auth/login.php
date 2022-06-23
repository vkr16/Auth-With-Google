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
    <script src="public/libs/JQuery/jquery.js"></script>
    <script src="public/libs/Notiflix/notiflix-aio-3.2.5.min.js"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <title>Masuk - AkuOnline</title>
</head>

<body>

    </style>

    <div class="w-full h-auto md:max-w-sm md:mx-auto">
        <img src="public/img/secure.jpg" alt="">
        <div class="mx-6">
            <h1 class="text-4xl font-Poppins">Masuk</h1>


            <form action="" class="mt-6">
                <div class="input-group">
                    <label for="emailField" class="text-lg mb-2">Email</label>
                    <input type="text" name="email" id="emailField" class="border rounded-lg w-full h-10 outline-none px-4 py-2 focus:ring focus:ring-cyan-500">
                </div>
                <div class="input-group mt-4">
                    <label for="passwordField" class="text-lg mb-2">Kata sandi</label>
                    <input type="password" name="password" id="passwordField" class="border rounded-lg w-full h-10 outline-none px-4 py-2 focus:ring focus:ring-cyan-500">
                </div>
                <div class="input-group mt-6">
                    <label for="saveSession" role="button" class="flex select-none">
                        <input type="checkbox" name="rememberSession" id="saveSession" onchange="toggle()" hidden>
                        <div class="self-center bg-white outline outline-1 outline-slate-300 rounded-full w-8 h-5 pt-1 px-1  transition-all duration-300" id="outerswitch">
                            <div class="bg-slate-300 w-3 h-3 rounded-full transition-all duration-300" id="innerswitch">
                            </div>
                        </div>
                        <p class="ml-2 font-sans" id="textSwitch">Ingat saya</p>
                    </label>
                </div>
                <div class="flex justify-between mt-6 gap-2">
                    <button type="button" class="w-24 h-10 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-md px-3 py-1 text-white text-center font-ProductSans self-center scale-100 active:scale-90 transition-all duration-75">Masuk</button>

                    <p class="self-center">atau</p>
                    <div class="self-center">
                        <div id="g_id_onload" data-client_id="515308257898-vun1m6b7ui4jo34su8km9bo1b9kn1h70.apps.googleusercontent.com" data-context="use" data-ux_mode="popup" data-callback="responseHandler">
                        </div>

                        <div class="g_id_signin" data-type="standard" data-shape="rectangular" data-theme="outline" data-text="signin_with" data-size="large" data-locale="id" data-logo_alignment="left">
                        </div>
                    </div>
                </div>

            </form>
            <br>
            <hr>
            <br>
            <div class="flex">
                <p class=" w-full self-center">Belum punya akun?</p>
                <a href="register" class="w-full h-10 bg-gradient-to-r from-fuchsia-400 to-purple-400 rounded-md px-3 py-2 text-white text-center font-ProductSans self-center scale-100 active:scale-90 transition-all duration-75">Buat akun baru</a>
            </div>
            <br>



        </div>
    </div>


    <script>
        function toggle() {
            if ($('#saveSession').is(":checked")) {
                $('#outerswitch').addClass('bg-blue-100 outline-blue-400').removeClass('bg-white').removeClass('outline-slate-300')
                $('#innerswitch').addClass('bg-gradient-to-r from-cyan-500 to-blue-500 translate-x-3').removeClass('bg-slate-300')

            } else {
                $('#outerswitch').removeClass('bg-blue-100 outline-blue-400').addClass('bg-white').addClass('outline-slate-300')
                $('#innerswitch').removeClass('bg-gradient-to-r from-cyan-500 to-blue-500 translate-x-3').addClass('bg-slate-300')
            }
        }

        function responseHandler(response) {
            const credential = parseJwt(response.credential);
            Notiflix.Block.dots('body', 'Harap tunggu...')
            $.post("login", {
                    action: "google",
                    uid: credential.sub,
                    name: credential.name,
                    email: credential.email
                })
                .done(function(data) {
                    if (data == '200') {
                        setTimeout(() => {
                            location.replace('user');
                        }, "2500")
                    } else {
                        Notiflix.Block.remove('body')
                        Notiflix.Confirm.show(
                            'Akun belum terdaftar',
                            'Lanjutkan membuat akun baru?',
                            'Ya',
                            'Tidak',
                            () => {
                                $.post("pending", {
                                        action: "set",
                                        uid: credential.sub,
                                        name: credential.name,
                                        email: credential.email
                                    })
                                    .done(function(data) {
                                        console.log(data)
                                        if (data == '409') {
                                            alert('User already exist')
                                        } else {
                                            location.replace('setup')
                                        }
                                    });
                            },
                        );
                    }
                });
        }

        function parseJwt(jwt) {
            var base64Url = jwt.split('.')[1];
            var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
            var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
                return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
            }).join(''));

            return JSON.parse(jsonPayload);
        };

        // Notiflix init

        Notiflix.Block.init({});
        Notiflix.Notify.init({});
        Notiflix.Confirm.init({
            titleColor: '#3b82f6',
            okButtonBackground: '#3b82f6',
            cancelButtonBackground: '#64748b',
            borderRadius: '5px'
        });
    </script>





</body>

</html>