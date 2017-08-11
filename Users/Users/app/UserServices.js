//Factory
app.factory("services", ['$http', function($http){
      //var baseService ='/##/T/'
      var obj = {};
      obj.getNews = function(){
        return $http.get('http://localhost/T/news');
      };
      obj.getNewsItembyId = function(id){
        return $http.get('http://localhost/T/newsByID?id='+id);
      };
      obj.getReviews = function(){
        return $http.get('http://localhost/T/review');
      }
      obj.getReviewByID = function(id){
        return $http.get('http://localhost/T/reviewByID?id='+id);
    }

    obj.getTrailers = function(){
      return $http.get('http://localhost/T/trailers');
    }

    obj.getTrailerByID = function(id){
      return $http.get('http://localhost/T/trailerByID?id='+id);
    }

    obj.getAllUCMovies = function(){
        return $http.get('http://localhost/T/upInMovies');
      }

    obj.getUCMovieById = function(id){
        return $http.get('http://localhost/T/movieByID?id='+id);
        // .then(function(data){
        //   alert(JSON.stringify(data.data));
        // });
    }

    obj.getAllEvents = function(){
        return $http.get('http://localhost/T/event');
      }

    obj.getEventById = function(id){
        return $http.get('http://localhost/T/eventByID?id='+id);
    }

    obj.getAllITheater = function(){
        return $http.get('http://localhost/T/inTheater');
      }
      obj.getITheaterById = function(id){
        return $http.get('http://localhost/T/inTheaterByID?id='+id);
      }

      obj.GAGalNames = function(){
        return $http.get('http://localhost/T/gallery');
      }
      obj.GIByGallery =function(Gname){
        //alert("services"+'http://localhost/T/imagesByGn?Gn="a"');
        //alert("services"+'http://localhost/T/imagesByGn?Gn='+'"'+Gname+'"');
        return $http.get('http://localhost/T/imagesByGn?Gn='+'"'+Gname+'"');
        // .then(
        //   function(data){
        //     alert(JSON.stringify(data.data));
        //   }
        // );
      }

    return obj;

}]);
