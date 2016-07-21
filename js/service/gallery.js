app.factory('GalleryFactory', function($http, $q, $timeout) {

  var factory = {
    gallerys: false,

    getGallerys: function() {
      var deferred = $q.defer();
      if (factory.gallery !== false) {
        deferred.resolve(factory.gallerys)
      } else {
        $http.get('/../data/argentic.json')
          .success(function(data, status) {
            factory.gallerys = data;
            $timeout(function() {
              deferred.resolve(factory.gallerys);
            }, 2000)
          })
          .error(function(data, status) {
            deferred.reject('Article introuvable ...')
          })

      }
      return deferred.promise;

    },

    getGallery: function(id) {
      var deferred = $q.defer();
      var gallery = {};
      var gallerys = factory.getGallery().then(function(gallerys) {
        angular.forEach(gallerys, function(value, key) {
          if (value.id == id) {
            gallery = value;
          }
        });
        deferred.resolve(gallery);
      }, function(msg) {
        deferred.reject(msg);
      })

      return deferred.promise;
    }


  };

  return factory;
});
