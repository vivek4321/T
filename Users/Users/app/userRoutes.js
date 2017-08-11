//Routes

app.config(["$routeProvider","$locationProvider",function($routeProvider, $locationProvider){
    $routeProvider
    //route to HomePage
    .when('/',{
      templateUrl : 'views/home.html',
      controller : 'userController'
    })
    .when('/news',{
      templateUrl : 'views/news.html',
      controller : 'newsController'
    })
    .when('/newsList/:id',{
      templateUrl : 'views/newsList.html',
      controller:'newsItemCtrl'
    })
    .when('/reviews',{
      templateUrl:'views/reviews.html',
      controller : 'reviewsController'
    })
    .when('/SingleMovieReview/:id',{
      templateUrl:'views/SingleMovieReview.html',
      controller:'reviewsItemCtrl'
    })
    .when('/trailers',{
      templateUrl: 'views/trailers.html',
      controller: 'trailersController'
    })
    .when('/upComing',{
      templateUrl: 'views/UpComming.html',
      controller: 'UCMCtrl'
    })
    .when('/singleUpMovInfo/:id',{
      templateUrl: 'views/singleUpMovInfo.html',
      controller : 'UCMListCtrl'
    })
    .when('/event',{
      templateUrl: 'views/events.html',
      controller: 'eventsController'
    })
    .when('/eventList/:id',{
      templateUrl: 'views/singleEventInfo.html',
      controller: 'eventListCtrl'
    })
    .when('/InTheaters',{
      templateUrl: 'views/inTheater.html',
      controller : 'InTheatersCtrl'
    })
    .when('/1InTheaters',{
      templateUrl: 'views/1InTheater.html'
    })
    .when('/images',{
      templateUrl: 'views/images.html',
      controller : 'imagesCtrl'
    })
    .when('/gallery/:name',{
      templateUrl: 'views/gallery.html',
      controller : 'galCtrl'
    })
    // .when('/about',{
    //   templateUrl: 'views/about.html',
    //   controller : ''
    // })
    // .when('/contact',{
    //   templateUrl: 'views/contact.html',
    //   controller : ''
    // })
    .otherwise(
      { redirectTo: '/' }
    )

}]);
