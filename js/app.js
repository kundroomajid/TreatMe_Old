if ('serviceWorker' in navigator) {
  window.addEventListener('load',function(){
    navigator.serviceWorker.register('./sw_pages.js').then(function(reg) {

      if(reg.installing) {
        console.log('Service worker installing');
      } else if(reg.waiting) {
        console.log('Service worker installed');
      } else if(reg.active) {
        console.log('Service worker active');
      }

    }).catch(function(error) {
      // registration failed
      console.log('Registration failed with ' + error);
    });
  });
}
