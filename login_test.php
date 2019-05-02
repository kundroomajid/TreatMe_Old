<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link href="https://bootswatch.com/yeti/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  
  <div class="container well" style="margin-top: 50px">
    <form id="register-form">
      <fieldset>
        <legend>Sign up for a business account</legend>
      </fieldset>
      <p>Create a login</p>

      <div class="form-group col-md-12">
        <input class="form-control" name="email" placeholder="Email address" type="email">
      </div>
      <div class="form-group col-md-6">
        <input class="form-control" name="password" id="password" placeholder="Password" type="password">
      </div>
      <div class="form-group col-md-6">
        <input class="form-control" name="password2" placeholder="Re-enter password" type="password">
      </div>
      <div class="clearfix">
      </div>
      <p>Tell us about your business</p>
      <div class="form-group col-md-6">
        <input class="form-control" name="firstName" placeholder="First name" type="text">
      </div>
     <div class="form-group col-md-6">
       <input class="form-control" name="secondName" placeholder="Last name" type="text">
     </div>

     <div class="form-group col-md-12">
       <input class="form-control" name="businessName" placeholder="Business name" type="text">
     </div>

     <div class="form-group col-md-12">
       <input class="form-control" name="phone" placeholder="Business phone" type="tel">
     </div>

     <div class="form-group col-md-12">
       <input class="form-control" name="address" placeholder="Business address" type="text">
     </div>

     <div class="form-group col-md-6">
       <input class="form-control" name="town" placeholder="Town" type="text">
     </div>

     <div class="form-group col-md-6">
       <input class="form-control" name="postcode" placeholder="Postcode" type="text">
     </div>
     <div class="form-group col-md-12">
       <div class="checkbox">
         <label>
           <input id="terms" name="terms" type="checkbox"> 
           I have read, consent and agree to Company's User Agreement and Privacy Policy
           (including the processing and disclosing of my personal data), and I am of 
           legal age. I understand that I can change my communication preferences at any
           time. Please read the Key Payment and ServiceInformation.
         </label>
       </div>
     </div>
      <div>
        <input class="btn btn-primary" id="submit-button" type="submit" value="Sign Up">
      </div>

    </form>
  </div>

  <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.3.min.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.min.js"></script>
  <script src="validation.js"></script>
<script>
  $(function() {

  $.validator.setDefaults({
    errorClass: 'help-block',
    highlight: function(element) {
      $(element)
        .closest('.form-group')
        .addClass('has-error');
    },
    unhighlight: function(element) {
      $(element)
        .closest('.form-group')
        .removeClass('has-error');
    },
    errorPlacement: function (error, element) {
      if (element.prop('type') === 'checkbox') {
        error.insertAfter(element.parent());
      } else {
        error.insertAfter(element);
      }
    }
  });

  $.validator.addMethod('strongPassword', function(value, element) {
    return this.optional(element) 
      || value.length >= 6
      && /\d/.test(value)
      && /[a-z]/i.test(value);
  }, 'Your password must be at least 6 characters long and contain at least one number and one char\'.')

  $("#register-form").validate({
    rules: {
      email: {
        required: true,
        email: true,
        remote: "http://localhost:3000/inputValidator"
      },
      password: {
        required: true,
        strongPassword: true
      },
      password2: {
        required: true,
        equalTo: '#password'
      },
      firstName: {
        required: true,
        nowhitespace: true,
        lettersonly: true
      },
      secondName: {
        required: true,
        nowhitespace: true,
        lettersonly: true
      },
      businessName: {
        required: true
      },
      phone: {
        required: true,
        digits: true,
        phonesUK: true
      },
      address: {
        required: true
      },
      town: {
        required: true,
        lettersonly: true
      },
      postcode: {
        required: true,
        postcodeUK: true
      },
      terms: {
        required: true
      }
    },
    messages: {
      email: {
        required: 'Please enter an email address.',
        email: 'Please enter a <em>valid</em> email address.',
        remote: $.validator.format("{0} is already associated with an account.")
      }
    }
  });

});
  
  </script>
  
</body>
  
  
  
</html>