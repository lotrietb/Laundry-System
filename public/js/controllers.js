var liveLaundryAppControllers = angular.module('liveLaundryAppControllers', []);

liveLaundryAppControllers.controller('LoginController', ['$scope', '$http', '$location', 'userService', function ($scope, $http, $location, userService) {
    $scope.login = function() {
        userService.login(
            $scope.email, $scope.password,
            function(response){
                $location.path('/');
            },
            function(response){
                alert('Something went wrong with the login process. Try again later!');
            }
        );
    }

    $scope.email = '';
    $scope.password = '';

    if(userService.checkIfLoggedIn())
        $location.path('/');
}]);

liveLaundryAppControllers.controller('SignupController', ['$scope', '$http', '$location', 'userService', function ($scope, $http, $location, userService) {
      $scope.signup = function() {
          userService.signup(
              $scope.name, $scope.email, $scope.password,
              function(response){
                  alert('Great! You are now signed in! Welcome, ' + $scope.name + '!');
                  $location.path('/');
              },
              function(response){
                  alert('Something went wrong with the signup process. Try again later.');
              }
          );
      }

      $scope.name = '';
      $scope.email = '';
      $scope.password = '';

      if(userService.checkIfLoggedIn())
          $location.path('/');
}]);

liveLaundryAppControllers.controller('MainController', ['$scope', '$http', '$location', 'userService', 'laundryService', function ($scope, $http, $location, userService, laundryService) {
      $scope.logout = function(){
          userService.logout();
          $location.path('/login');
      }

      $scope.create = function(){
          console.log($scope);
          return;
          laundryService.create({
              pickup_datetime: $scope.pickup_datetime,
              address: $scope.address,
              location: $scope.location
          }, function(){

              $('#addPickupModal').modal('toggle');
              $scope.currentPickupReset();
              $scope.refresh();

          }, function(){

              alert('Some errors occurred while communicating with the service. Try again later.');

          });

      }

      $scope.refresh = function(){

          laundryService.getAll(function(response){
              
              $scope.pickups = response;
          
          }, function(){
              
              alert('Some errors occurred while communicating with the service. Try again later.');
          
          });

      }

      $scope.currentPickupReset = function(){
          $scope.pickup_datetime = '';
          $scope.address = '';
          $scope.location = '';
      }

      if(!userService.checkIfLoggedIn())
          $location.path('/login');

      $scope.books = [];

      $scope.currentPickupReset();
      $scope.refresh();
}]);
