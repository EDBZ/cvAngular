app.service('getjson', ng(function($http) {
  return {
    recupdata: function(url) {
        return $http.get(url);
    }
  }
}));
