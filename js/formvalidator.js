
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
      if ((element.prop('type') === 'search') || (element.prop('type') === 'checkbox') || (element.prop('type') === 'radio')) {
        error.insertAfter(element.parent());
      } else {
        error.insertAfter(element);
      }
      
      
    }
    
  });

//  $.validator.addMethod('validateTime', function(value, element) {
//    return this.optional(element) 
//      || value.length >= 6
//      && /\d/.test(value)
//      && /[a-z]/i.test(value);
//  }, 'Your password must be at least 6 characters long and contain at least one number and one char\'.')
  
   //      validate contacts.php begins
  $("#contactform").validate({
    rules: {
      name: {
        required: true
      },
      phone: {
        required: true
      },
      email: {
        required: true,
        email : true
      },
      comment: {
        required: true
      }
      
      
    },
    messages: {
      name: {
        required: '<i style="color:red">Enter Your Name.</i>'
      },
      phone: {
        required: '<i style="color:red">Enter Contact Number.</i>'
      },
      email: {
        required: '<i style="color:red">Enter Your Email.</i>'
      },
      comment: {
        required: '<i style="color:red">Enter Your Message.</i>'
      },
    }
  });
    
    //  validate contacts.php ends  
  
  
  
  
  
  //      validate registerclinic.php begins
  $("#registerClinic").validate({
    rules: {
      name: {
        required: true
      },
      phone_no: {
        required: true
      },
      address: {
        required: true
      }
    },
    messages: {
      name: {
        required: '<i style="color:red">Enter Name Of Clinic.</i>'
      },
      phone_no: {
        required: '<i style="color:red">Enter Contact Number Of Clinic.</i>'
      },
      address: {
        required: '<i style="color:red">Enter Address Of Clinic.</i>'
      },
    }
  });
    
    //  validate registerclinic.php ends  
    
// validate register-doctor3.php validation
  $("#registerDoctor3").validate({
    rules: {
      specialization: {
        required: true
      },
      degree: {
        required: true
      },
      institution: {
        required: true
      },
      experience: {
        required: true
      },
      registration_no: {
        required: true
      },
      registration_year: {
        required: true
      },
      registration_council: {
        required: true
      },
      clinic: {
        required: true
      },
      address: {
        required: true
      },
      fee: {
        required: true,
        number : true
      },
      c_validity: {
        required: true,
        number :true
      },
      morning_start_time: {
        required: true
      },
      morning_end_time: {
        required: true
        
      },
      evening_start_time: {
        required: true
      },
      evening_end_time: {
        required: true
      },
      
    },
    messages: 
    {
      specialization: {
         required: '<i style="color:red">Please Enter Your Specalization.</i>'
      },
      degree: {
        required: '<i style="color:red">Enter Name Of Your Degree.</i>'
        
      },
      institution:
      {
        required: '<i style="color:red">Enter Institution Name.</i>'
    },
      experience:
      {
      required: '<i style="color:red">Please Enter Your Experience (in Years).</i>'
      },
      
      registration_no: {
         required: '<i style="color:red">Enter Your Registration Number.</i>'
      },
      registration_year: {
        required: '<i style="color:red">Year Of Registration.</i>'
        
      },
       registration_council:
      {
        required: '<i style="color:red">Name Of Registration Council.</i>'
    },
      clinic:
      {
      required: '<i style="color:red">Enter Name Of Clinic.</i>'
      },
      
      address: {
         required: '<i style="color:red">Please Enter Address Of Clinic.</i>'
      },
      fee: {
        required: '<i style="color:red">Consultation Charges/ Fee.</i>'
        
      },
      c_validity:
      {
        required: '<i style="color:red">Appointment Valid for.</i>'
    },
       morning_start_time:
      {
      required: '<i style="color:red">Avalaible From in The Morning.</i>'
      },
      
       morning_end_time: {
         required: '<i style="color:red">Avalaible To in The Morning.</i>'
      },
       evening_start_time: {
        required: '<i style="color:red">Avalaible From in The Evening.</i>'
        
      },
        evening_end_time:
      {
        required: '<i style="color:red">Avalaible To In The Evening.</i>'
    },
      
      
    }
  });
    
    //register-doctor2.php validation ends      
        
    
    
    
    
//    validate register-doctor2.php validation
  $("#docRegister2").validate({
    rules: {
      name: {
        required: true
      },
      phone_no: {
        required: true,
        min : 10
      },
      dob: {
        required: true,
        date : true
      },
      gender: {
        required: true
      }
    },
    messages: 
    {
      name: {
         required: '<i style="color:red">Enter Your Name.</i>'
      },
      phone_no: {
        required: '<i style="color:red">Enter Your Phone Number.</i>'
        
      },
      dob:
      {
        required: '<i style="color:red">Enter Your Date Of Birth.</i>',
        date : '<i style="color:red"> Enter Date in DD/MM/YY format.</i>' 
    },
      gender:
      {
      required: '<i style="color:red">Please Specify Your Gender.</i>'
      }
    }
  });
    
    //register-doctor2.php validation ends      
    
    
    
    
    
    
//      validate index.php search begins
  $("#searchForm").validate({
    rules: {
      q: {
        required: true
      }
    },
    messages: {
      q: {
        required: '<i style="color:red">Enter Name of Doctor or Specalization.</i>'
      }
    }
  });
    
    //  validate index.php search ends     
    
//    validate register2.php
  $("#registerForm").validate({
    rules: {
      name: {
        required: true
      },
      phone_no: {
        required: true
      },
      dob: {
        required: true,
        date : true
      },
      address: {
        required: true
      },
      height: {
        required: true
      },
      weight: {
        required: true
      }
    },
    messages: 
    {
      name: {
         required: '<i style="color:red">Enter Your Name.</i>'
      },
      phone_no: {
        required: '<i style="color:red">Enter Your Phone Number.</i>'
      },
      dob:
      {
        required: '<i style="color:red">Enter Your Date Of Birth.</i>',
        date : '<i style="color:red"> Enter Date in DD/MM/YY format.</i>' 
    },
      address:
      {
      required: '<i style="color:red">Enter Your Address.</i>'
      },
      height: {
         required: '<i style="color:red">Enter Your Height.</i>'
      },
      weight: {
        required: '<i style="color:red">Enter Your Weight.</i>'
      }
    }
  });
    
    //register2.php validation ends    
    
    
    
    
    
    
    
    
//      validate login.php
  $("#loginForm").validate({
    rules: {
      email_id: {
        required: true,
        email:true
      },
      password:
      {
        required:true
      }
    },
    messages: {
      email_id: {
        required: '<i style="color:red">Please enter an email address.</i>',
        email:'<i style="color:red">Enter A Valid Email Address.</i>'
        
      },
      password:{
      required: '<i style="color:red">Please Enter Your Password.</i>',
    }
    }
  });
    
    // validate login.php ends        


//      validate verify.php
  $("#verify").validate({
    rules: {
      hash: {
        required: true
      }
    },
    messages: {
      hash: {
         required: '<i style="color:red">Please Enter Verification code recieved On your Mail id.</i>'
      }
    }
  });
    
    // validate verify.php    
    
    
    
    
    
//    validate register.php
  $("#myForm").validate({
    rules: {
      user_email: {
        required: true,
        email: true,
      },
      user_password: {
        required: true
      },
      password2: {
        required: true
      },
      check_2: {
        required: true
      }
    },
    messages: {
      user_email: {
         required: '<i style="color:red">Please enter an email address.</i>',
        email:'<i style="color:red">Enter A Valid Email Address.</i>'
      },
      check_2: {
        required: '<i style="color:red">Please Accept Terms and Conditions.</i>'
      },
      password2:
      {
        required: '<i style="color:red">Please Re-enter same Password.</i>'
        
    },
      user_password:
      {
      required: '<i style="color:red">Please Enter Password.</i>'
        
    }
    }
  });
    
    //register.php validation ends
    

    
    
    
    
    

});
  
