<!DOCTYPE html>
<html lang="en" class="link-html">
    <head>
        <title></title>
        <base href="https://demo.epesantren.co.id/apk/">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        
                    <link href="https://demo.epesantren.co.id/apk/image/logo.png" rel="shortcut icon" />
        
        
                    <link href="https://demo.epesantren.co.id/apk/assets/css/bootstrap.min.css?v=740" rel="stylesheet" media="screen">
                    <link href="https://demo.epesantren.co.id/apk/assets/css/custom.css?v=740" rel="stylesheet" media="screen">
                    <link href="https://demo.epesantren.co.id/apk/assets/css/link-custom.css?v=740" rel="stylesheet" media="screen">
                    <link href="https://demo.epesantren.co.id/apk/assets/css/animate.min.css?v=740" rel="stylesheet" media="screen">
        
                                <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
            <style>
                body {
                    font-family: 'Lato', sans-serif !important;
                }
            </style>
        
        
        
        <link rel="canonical" href="https://demo.epesantren.co.id/apk/" />
    </head>

    
<body class="link-body link-body-background-three" style="">
    <div class="container animated fadeIn">
        <div class="row d-flex justify-content-center text-center">
            <div class="col-md-8 link-content">

                
                <header class="d-flex flex-column align-items-center" style="color: #000000">
                    <img id="image" src="https://demo.epesantren.co.id/apk/uploads/avatars/" alt="Avatar" class="link-image" style="display: none;" />

                    <div class="d-flex flex-row align-items-center mt-4">
                        <h1 id="title">Informasi</h1>

                                            </div>

                    <p id="description">Pondok Pesantren</p>
                </header>

                <main id="links" class="mt-4">

                                            
                            
                            <div data-link-id="542">
                                
<div class="my-3">
    <h2 class="h4" style="color: #0100FF">Himbauan</h2>
    <p class="" style="color: #fff">Wali Santri Pondok Pesantren yang datang ke pesantren harus mematuhi protokol kesehatan memakai masker, cuci tangan, dan jaga jarak.</p>
</div>

                            </div>

                        
                            
                            <div data-link-id="543">
                                
<div class="my-3">
    <h2 class="h4" style="color: #0100FF">Cara Login Wali Santri</h2>
    <p class="" style="color: #fff">Login menggunakan Nomor Induk Santri dan Pasword yang di dapatkan dari admin Pondok Pesantren</p>
</div>

                            </div>

                        
                            
                            <div data-link-id="544">
                                
<div class="my-3">
    <h2 class="h4" style="color: #0100FF">Cara Mendapatkan NIS dan Pasword</h2>
    <p class="" style="color: #fff">Silahkan hubungi call center atau klik tombol di bawah ini</p>
</div>

                            </div>

                        
                            
                            <div data-link-id="545">
                                
<div class="my-3">
    <a href="https://api.whatsapp.com/send?phone=6281233640001&text=Mohon%20informasi%20NIS%20dan%20Pasword%0A%0A*Nama%20%3A*%0A*Kelas%20%3A*%0A%0ATerimakasih" data-location-url="igLRJvLlGR" class="btn btn-block btn-primary link-btn link-btn-rounded animated infinite pulse delay-2s" style="background: #fff;color: #000">

        
        Request NIS dan Pasword    </a>
</div>


                            </div>

                                            
                                        <div id="socials" class="d-flex flex-wrap justify-content-center mt-5">

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                    </div>
                    
                </main>

                
                <footer class="link-footer">
                                                                        <a id="branding" href="https://demo.epesantren.co.id/apk/" style="color: #000000">Halaman Utama</a>
                                                            </footer>

            </div>
        </div>
    </div>

    </body>






    <input type="hidden" id="url" name="url" value="https://demo.epesantren.co.id/apk/" />
    <input type="hidden" name="global_token" value="e62caca46b6ba6edfb5c47aa93d57f8c" />
    <input type="hidden" name="number_decimal_point" value="." />
    <input type="hidden" name="number_thousands_separator" value="," />

            <script src="https://demo.epesantren.co.id/apk/assets/js/libraries/jquery.min.js?v=740"></script>
            <script src="https://demo.epesantren.co.id/apk/assets/js/libraries/popper.min.js?v=740"></script>
            <script src="https://demo.epesantren.co.id/apk/assets/js/libraries/bootstrap.min.js?v=740"></script>
            <script src="https://demo.epesantren.co.id/apk/assets/js/main.js?v=740"></script>
            <script src="https://demo.epesantren.co.id/apk/assets/js/functions.js?v=740"></script>
            <script src="https://demo.epesantren.co.id/apk/assets/js/libraries/fontawesome.min.js?v=740"></script>
    
    <script>
    /* Internal tracking for biolink links */
    $('[data-location-url]').on('click', event => {

        let base_url = $('[name="url"]').val();
        let url = $(event.currentTarget).data('location-url');

        $.ajax(`${base_url}${url}?no_redirect`);
    });
</script>
<script>
    /* Go over all mail buttons to make sure the user can still submit mail */
    $('form[id^="mail_"]').each((index, element) => {
        let link_id = $(element).find('input[name="link_id"]').val();
        let is_converted = localStorage.getItem(`mail_${link_id}`);

        if(is_converted) {
            /* Set the submit button to disabled */
            $(element).find('button[type="submit"]').attr('disabled', 'disabled');
        }
    });
        /* Form handling for mail submissions if any */
    $('form[id^="mail_"]').on('submit', event => {
        let base_url = $('[name="url"]').val();
        let link_id = $(event.currentTarget).find('input[name="link_id"]').val();
        let is_converted = localStorage.getItem(`mail_${link_id}`);

        if(!is_converted) {

            $.ajax({
                type: 'POST',
                url: `${base_url}link-ajax`,
                data: $(event.currentTarget).serialize(),
                success: (data) => {
                    let notification_container = $(event.currentTarget).find('.notification-container');

                    if (data.status == 'error') {
                        notification_container.html('');

                        display_notifications(data.message, 'error', notification_container);
                    } else if (data.status == 'success') {

                        display_notifications(data.message, 'success', notification_container);

                        setTimeout(() => {

                            /* Hide modal */
                            $(event.currentTarget).closest('.modal').modal('hide');

                            /* Remove the notification */
                            notification_container.html('');

                            /* Set the localstorage to mention that the user was converted */
                            localStorage.setItem(`mail_${link_id}`, true);

                            /* Set the submit button to disabled */
                            $(event.currentTarget).find('button[type="submit"]').attr('disabled', 'disabled');

                        }, 1000);

                    }
                },
                dataType: 'json'
            });

        }

        event.preventDefault();
    })
</script>
</html>
