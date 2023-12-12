<?php
require_once('header.php');
?>

<link rel="stylesheet" href="./assets/css/contact.css">


<section class="contact_us">
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="contact_inner">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="contact_form_inner">
                                <div class="contact_field">
                                    <h3>Contatc Us</h3>
                                    <p>If you have any questions or comments, please feel free to contact us using the following information. We will be happy to assist you and provide you with more details about our services.</p>
                                    <div class="statusMsg"></div>
                                    <form id="contact_form">
                                        <input type="text" name="name" class="form-control form-group" placeholder="Name" />
                                        <input type="email" name="email" class="form-control form-group" placeholder="Email" />
                                        <textarea name="message" class="form-control form-group" placeholder="Message"></textarea>
                                        <button type="submit" class="contact_form_submit">Send</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="right_conatct_social_icon d-flex align-items-end">
                                <div class="socil_item_inner d-flex">
                                    <li><a href="#"><i class="fab fa-facebook-square"></i></a></li>
                                    <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="contact_info_sec">
                        <h4>Contact Info</h4>
                        <div class="d-flex info_single align-items-center">
                            
                            <span><i class="fas fa-headset"></i> +2010 01635 483</span>
                        </div>
                        <div class="d-flex info_single align-items-center">
                            
                            <span><i class="fas fa-envelope-open-text"></i> info@mariamalbossery.com</span>
                        </div>
                        <div class="d-flex info_single align-items-center">
                            
                            <span><i class="fas fa-map-marked-alt"></i> Our office is located in Second New Cairo, Cairo Governorate 4735632.</span>
                        </div>
        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).ready(function(e){
        // Submit form data via Ajax
        $("#contact_form").on('submit', function(e){
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'config/contact.php',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('.contact_form_submit').attr("disabled","disabled");
                    $('#contact_form').css("opacity",".5");
                },
                success: function(response){
                    $('.statusMsg').html('');
                    if(response.status == 1){
                        $('#contact_form')[0].reset();
                        $('.statusMsg').html('<p class="alert alert-success">'+response.message+'</p>');
                    }
                    
                    else{
                        $('.statusMsg').html('<p class="alert alert-danger">'+response.message+'</p>');
                    }

                    $('#contact_form').css("opacity","");
                    $(".contact_form_submit").removeAttr("disabled");
                }
            });
        });
    });
</script>

<?php
require_once('footer.php');
?>