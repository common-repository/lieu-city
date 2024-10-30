
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lieu Plugin - Login</title>        
</head>

<body>

    <div class="container-fluid login-page__container">
        <div class="row g-0">
            <!--HEADER-->
            <section class="col-12 login-page__header login-page__section">
                <img class="lieu-logo" src="<?php echo plugins_url(('/../assets/svg/lieu_cropped_logo.svg'), __FILE__) ?>">
            </section>
            <!--HEADER-->

            <!--PAGE CONTENT-->
            <section class="col-12 login-page__content login-page__section">
                <div class="login-page__form-wrapper">
                    <!--FORM-->
                    <form class="login-page__form" method="post">
                        <div class="login-page__form-header">
                            <h3 class="login-form-header-title">Log In</h3>
                        </div>
                        <div class="login-page__form-content">
                            <div class="login-input-container">
                                <input type="text" class="login-input" name="lieu_email" id="lieu_email" autocomplete="lieu_mail">
                                <label for="lieu_email">Email</label>
                                <div class="invalid-login-feedback">
                                    <span>
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                        Password non valida
                                    </span>
                                </div>
                            </div>

                            <div class="login-input-container  login-invalid-field">
                                <input type="password" class="login-input" name="lieu_password" id="lieu_password" autocomplete="lieu_pass">
                                <label for="lieu_password">Password</label>
                                <span class="field-icon toggle-password"></span>
                                <div class="invalid-login-feedback">
                                    <span>
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                        Password non valida
                                    </span>
                                </div>
                            </div>
                           
                            <div class="social-button-container">
                                <!--<button class="lieu__button lieu__button-login lieu__social-facebook"></button>
                                <button class="lieu__button lieu__button-login lieu__social-google"></button>-->
                            </div>

                        </div>

                        <div class="login-page__form-footer">
                            
                            <span id ="lieu_login_error" style="display:none" >
                                Errore di login
                            </span>
                        
                            <!--<div class="checkbox__container mt-3">
                                <input id="check1" type="checkbox" class="switch keep_login_switch">
                                <label for="check1">
                                    <small style="font-weight: 600;">Rimani connesso</small>
                                </label>
                            </div>-->

                            <div class="d-flex justify-content-center mt-3">
                                <button class="lieu__button" name="lieu_login_button">Accedi</button>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <button class="lieu__button" name="lieu_register_button" onclick="window.open('https://lieu.city/')" >Registrati</button>
                            </div>
                            
                        </div>
                    </form>
                    <!--FORM-->

                </div>
            </section>
            <!--PAGE CONTENT-->

            <!--PAGE FOOTER-->
            <section class="col-12 login-page__footer login-page__section">

            </section>
            <!--PAGE FOOTER-->

        </div>
    </div>

</body>

</html>