app.service('upload', function() {
  that = this;
  this.files = [];

  this.getFiles = function(){
    return this.files;
  }
})
