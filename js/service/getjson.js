app.service('getjson', function($http) {
  return {
    recupdata: function(url) {
      return $http.get(url);
    },
    recupPathJson: function(data) {
      var arrPathJson = _.pluck(data, 'path');
      return arrPathJson;
    },
    firstPath: function(arr) {
      var first = _.first(arr);
      return first;
    },
    lastPath: function(arr) {
      var last = _.last(arr);
      return last;
    },
    last_imgs: function(arr) {
      var arr_path_gal = _.pluck(arr, 'path');
      var arr_last_imgs = [];
      for (prop in arr_path_gal) {
        $http.get(arr_path_gal[prop])
          .success(function(data) {
            arr_last_imgs.push(_.last(_.pluck(data, 'info_photo')))
          });
        arr_last_imgs.reverse()
      }
      return arr_last_imgs
    }
  }
});
