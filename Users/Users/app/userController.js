//Angular Script
var app = angular.module('app', ['ngRoute'])

//<-- start   Angular controllers -->
app.controller('userController',["$scope","services", function($scope,services){
   services.getNews().then(
      function(data){
        $scope.newsObjH =data.data;
      }
    );
  services.getReviews().then(
     function(data){
       $scope.reviewsObjH = data.data;
     }
   );
  services.getTrailers().then(
    function(data){
      $scope.traiObjH = data.data;
    }
  );
  services.GAGalNames().then(
    function(data){
      $scope.galObjH = data.data;
    }
  );
  services.getTrailers().then(
    function(data){
    $scope.traiObjH = data.data;
    }
  );

  services.getAllUCMovies().then(function(data){
    $scope.UCMoviesH = data.data;
  });

  services.getAllITheater().then(function(data){
  $scope.ITheatersH = data.data;
 });
 services.getAllEvents().then(function(data){
   $scope.eventsH = data.data;
 });
 services.getAllUCMovies().then(function(data){
   $scope.UCMovies = data.data;
 });

}]);
app.controller('newsController', ["$scope","$rootScope","services","$route",function( $scope , $rootScope, services, $route){
      services.getNews().then(function(data){
        $scope.newsList = data.data;
      });
}]);
app.controller('newsItemCtrl', [ "$scope","$rootScope","services","$routeParams","$route" ,function($scope , $rootScope, services,$routeParams, $route){
  services.getNewsItembyId($route.current.params.id).then(function(data){
    $rootScope.newsItem = data.data;
    });
}]);
app.controller('reviewsController', function( $scope , services, $rootScope){
        services.getReviews().then(function(data){
          $scope.movieReviews = data.data;
        });
});
app.controller('reviewsItemCtrl', [ "$scope","$rootScope","services","$routeParams","$route" ,function($scope , $rootScope, services,$routeParams, $route){
  services.getReviewByID($route.current.params.id).then(function(data){
    $rootScope.movieItem = data.data;
    });
}]);
app.controller('trailersController', function( $scope , services, $rootScope){
        services.getTrailers().then(function(data){
          $scope.movieTrailers = data.data;
        });
});
app.controller('UCMCtrl', function( $scope , services, $rootScope){
        services.getAllUCMovies().then(function(data){
          $scope.upcomingMovies = data.data;
        });
});
app.controller('UCMListCtrl', ["$scope","$rootScope","services","$routeParams","$route" ,function($scope, $rootScope, services,$routeParams, $route){
  services.getUCMovieById($route.current.params.id).then(function(data){
    //alert($route.current.params.id);
    $scope.testUCMovie = data.data;
    //alert(JSON.stringify(data.data));
  });
}]);
app.controller('eventsController', function( $scope , services, $rootScope){
        services.getAllEvents().then(function(data){
          $scope.events = data.data;
        });
});
app.controller('eventListCtrl',["$scope","$rootScope","services","$routeParams","$route" ,function($scope, $rootScope, services,$routeParams, $route){
  services.getEventById($route.current.params.id).then(function(data){
    //alert($route.current.params.id);
    $scope.testEvent = data.data;
    //alert(JSON.stringify(data.data));
  });
}]);

    app.controller('InTheatersCtrl', function($scope,services){
      function refreshITheater(){
        services.getAllITheater().then(function(data){
        $scope.ITheaters = {}
        $scope.ITheaters = data.data;
       });
      }
    refreshITheater();

    $scope.getITheaterById = function(id){
      services.getITheaterById(id).then(function(data){
        $scope.ITMovie = data.data;
      });
    }
    });

    app.controller('imagesCtrl',function($scope,$rootScope,services){
      function refreshImaages(){
        services.GAGalNames().then(function(data){
          //alert(JSON.stringify(data.data));
          $scope.galnames = {}
          $scope.galnames = data.data;
        });
      }
      refreshImaages();
    });

    app.controller('galCtrl',["$scope","$rootScope","services","$routeParams","$route" ,function($scope, $rootScope, services,$routeParams, $route){
      services.GIByGallery($route.current.params.name).then(function(data){
        $rootScope.gallery = {}
        $rootScope.gallery = data.data;
        //alert(JSON.stringify(data.data));
      });
    }]);
