<?php
require_once('header.php');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/theme.min.css">
<link rel="stylesheet" href="./assets/css/book.css">


<div class="formbold-main-wrapper">
  <!-- Author: FormBold Team -->
  <!-- Learn More: https://formbold.com -->
  <div class="formbold-form-wrapper">
    <!-- Status message -->
    <div class="statusMsg"></div>
    <form id="book_appointment">
      <div class="formbold-mb-5">
        <label for="name" class="formbold-form-label"> *Full Name </label>
        <input
          type="text"
          name="name"
          id="name"
          placeholder="Full Name"
          class="formbold-form-input"
        />
      </div>
      <div class="formbold-mb-5">
        <label for="phone" class="formbold-form-label"> *Phone Number </label>
        <input
          type="text"
          name="phone"
          id="phone"
          placeholder="Enter your phone number"
          class="formbold-form-input"
        />
      </div>
      <div class="formbold-mb-5">
        <label for="email" class="formbold-form-label"> Email Address </label>
        <input
          type="email"
          name="email"
          id="email"
          placeholder="Enter your email"
          class="formbold-form-input"
        />
      </div>
      <div class="flex flex-wrap formbold--mx-3">
        <div class="w-full sm:w-half formbold-px-3">
          <div class="formbold-mb-5 w-full">
            <label for="datepicker" class="formbold-form-label"> *Date </label>
            <input
              type="date"
              name="date"
              id="datepicker"
              class="formbold-form-input"
              oninput="disableWeekends()"
            />
          </div>
        </div>
        <div class="w-full sm:w-half formbold-px-3">
          <div class="formbold-mb-5">
            <label for="time" class="formbold-form-label"> *Time </label>
            <select name="time" id="time" class="formbold-form-input">
                <option value=""></option>
                <option value="10">10 AM</option>
                <option value="11">11 AM</option>
                <option value="12">12 PM</option>
                <option value="13">01 PM</option>
                <option value="14">02 PM</option>
                <option value="15">03 PM</option>
                <option value="16">04 PM</option>
                <option value="17">05 PM</option>
                <option value="18">06 PM</option>
                <option value="19">07 PM</option>
                <option value="20">08 PM</option>
            </select>
            
          </div>
        </div>
      </div>

      <div>
        <button class="formbold-btn" type="submit">Book Appointment</button>
      </div>
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    function disableWeekends() {
        var $j = jQuery.noConflict();
    var selectedDate = new Date(document.getElementById('datepicker').value);
    var day = selectedDate.getDay();
    if (day === 5) {
        alert('Weekend is disabled for selection');
        document.getElementById('datepicker').value = '';
    }
    }
</script>

<script>
    $(document).ready(function(e){
        // Submit form data via Ajax
        $("#book_appointment").on('submit', function(e){
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'config/book_appointment.php',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('.formbold-btn').attr("disabled","disabled");
                    $('#book_appointment').css("opacity",".5");
                },
                success: function(response){
                    $('.statusMsg').html('');
                    if(response.status == 1){
                        $('#book_appointment')[0].reset();
                        $('.statusMsg').html('<p class="alert alert-success">'+response.message+'</p>');
                    }
                    
                    else{
                        $('.statusMsg').html('<p class="alert alert-danger">'+response.message+'</p>');
                    }

                    $('#book_appointment').css("opacity","");
                    $(".formbold-btn").removeAttr("disabled");
                }
            });
        });
    });
</script>
<?php
require_once('footer.php');
?>