<?php
require_once('header.php');
?>
<link rel="stylesheet" href="assets/css/login.css">

<section class="user">
  <div class="user_options-container">
    <div class="user_options-text">
      <div class="user_options-unregistered">
        <h2 class="user_unregistered-title">Don't have an account?</h2>
        <p class="user_unregistered-text">Step into style and elegance with our fashion platform.</p>
        <button class="user_unregistered-signup" id="signup-button">Sign up</button>
      </div>

      <div class="user_options-registered">
        <h2 class="user_registered-title">Have an account?</h2>
        <p class="user_registered-text">Make a bold statement in the world of fashion and let your unique style take center stage with us.</p>
        <button class="user_registered-login" id="login-button">Login</button>
      </div>
    </div>
    
    <div class="user_options-forms" id="user_options-forms">
      <div class="user_forms-login">
        <h2 class="forms_title">Login</h2>
        <form class="login_form" id="login_form">
          <fieldset class="forms_fieldset">
            <div class="forms_field">
              <input type="email" placeholder="Email" name="email" class="forms_field-input" required autofocus />
            </div>
            <div class="forms_field">
              <input type="password" placeholder="Password" name="password" class="forms_field-input" required />
            </div>
          </fieldset>
          <div class="forms_buttons">
            <button type="button" class="forms_buttons-forgot">Forgot password?</button>
            <input type="submit" value="Log In" class="forms_buttons-action login_button">
          </div>
        </form>
      </div>
      <div class="statusMsg"></div>

      <div class="user_forms-signup">
        <h2 class="forms_title">Sign Up</h2>
        <form class="register_form" id="register_form">
          <fieldset class="forms_fieldset">
            <div class="forms_field">
              <input type="text" placeholder="Full Name" name="name" class="forms_field-input" required />
            </div>
            <div class="forms_field">
              <input type="email" placeholder="Email" name="email" class="forms_field-input" required />
            </div>
            <div class="forms_field">
              <input type="text" placeholder="Phone Number" name="phone" class="forms_field-input" required />
            </div>
            <div class="forms_field">
              <input type="password" placeholder="Password" name="password" class="forms_field-input" required />
            </div>
          </fieldset>
          <div class="forms_buttons">
            <input type="submit" value="Sign up" class="forms_buttons-action register_button">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>


<!----------Designed By Pradeep Singh Tomar------------>


<script>
    /**
     * Variables
     */
    const signupButton = document.getElementById('signup-button'),
        loginButton = document.getElementById('login-button'),
        userForms = document.getElementById('user_options-forms')

    /**
     * Add event listener to the "Sign Up" button
     */
    signupButton.addEventListener('click', () => {
    userForms.classList.remove('bounceRight')
    userForms.classList.add('bounceLeft')
    }, false)

    /**
     * Add event listener to the "Login" button
     */
    loginButton.addEventListener('click', () => {
    userForms.classList.remove('bounceLeft')
    userForms.classList.add('bounceRight')
    }, false)
</script>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).ready(function(e){
        // Submit form data via Ajax
        $("#register_form").on('submit', function(e){
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'config/register.php',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('.register_button').attr("disabled","disabled");
                    $('#register_form').css("opacity",".5");
                },
                success: function(response){
                    $('.statusMsg').html('');
                    if(response.status == 1){
                        $('#register_form')[0].reset();
                        $('.statusMsg').html('<p class="alert alert-success">'+response.message+'</p>');
                    }
                    
                    else{
                        $('.statusMsg').html('<p class="alert alert-danger">'+response.message+'</p>');
                    }

                    $('#register_form').css("opacity","");
                    $(".register_button").removeAttr("disabled");
                }
            });
        });
        //
        // Submit form data via Ajax
        $("#login_form").on('submit', function(e){
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'config/login.php',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('.login_button').attr("disabled","disabled");
                    $('#login_form').css("opacity",".5");
                },
                success: function(response){
                    $('.statusMsg').html('');
                    if(response.status == 1){
                        $('#login_form')[0].reset();
                        alert(response.message);
                        window.location.href="index.php";
                    }
                    
                    else{
                        $('.statusMsg').html('<p class="alert alert-danger">'+response.message+'</p>');
                    }

                    $('#login_form').css("opacity","");
                    $(".login_button").removeAttr("disabled");
                }
            });
        });
        //
    });
</script>

<?php
require_once('footer.php');
?>
