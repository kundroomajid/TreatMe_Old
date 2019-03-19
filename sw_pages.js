const cacheName='v1';

self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(cacheName).then(function(cache) {
      return cache.addAll(
        [
          'offline.php'
        ]
      );
    })
  );
});

self.addEventListener('fetch', function(e) {
  e.respondWith(
    caches.match(e.request)
      .then(function(res){
        if(res !== undefined)
          return res;
        else{
          return fetch(e.request).then(function(res){
            let resClone = res.clone();
            caches.open(cacheName).then(function(cache){ cache.put(e.request,resClone); });
            return res;
          });
        }
      })
      .catch(function(){ return caches.match('offline.php'); })
    );
});
