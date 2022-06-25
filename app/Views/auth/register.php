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
    <script src="public/libs/Notiflix/notiflix-aio-3.2.5.min.js"></script>

    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="public/libs/JQuery/jquery.js"></script>
    <title>Daftar - AkuOnline</title>
</head>

<body>
    <div class="w-full md:w-2/3 h-auto md:mx-auto md:flex ">
        <div class="mx-auto md:mt-32 origin-center md:w-1/2">
            <img src="public/img/secure.jpg" alt="">
        </div>
        <div class="mx-6 mt-10 px-10 md:w-1/2 md:mx-auto md:mt-40">
            <h1 class="text-4xl font-Poppins">Daftar</h1>
            <p class="text-slate-900">Silahkan mendaftar dengan akun google anda.</p>
            <div class="mt-6 w-full">
                <div id="googleBtn">
                    <div id="g_id_onload" data-client_id="515308257898-vun1m6b7ui4jo34su8km9bo1b9kn1h70.apps.googleusercontent.com" data-context="use" data-ux_mode="popup" data-callback="responseHandler">
                    </div>

                    <div class="g_id_signin" data-type="standard" data-shape="rectangular" data-theme="outline" data-text="signup_with" data-size="large" data-locale="id" data-logo_alignment="left">
                    </div>
                </div>

                <div class="flex justify-start gap-4 mt-6 xl:flex-row xl:gap-4 md:flex-col md:gap-1">
                    <p class="mt-4 w-full self-center">Sudah punya akun?</p>

                    <a href="login" class="w-full h-10 mt-4 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-md px-3 py-2 text-white text-center font-ProductSans self-center scale-100 active:scale-90 transition-all duration-75">Masuk</a>
                </div>
            </div>
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

            $.post("pending", {
                    action: "set",
                    uid: credential.sub,
                    name: credential.name,
                    email: credential.email
                })
                .done(function(data) {
                    console.log(data)
                    if (data == '409') {
                        Notiflix.Notify.info('Pengguna sudah terdaftar')
                        Notiflix.Block.dots('body', 'Mengalihkan untuk login...')
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
                                }
                            });
                    } else {
                        location.replace('setup')
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