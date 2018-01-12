app.controller('ItemController', ['$scope', '$state', 'ItemService', function($scope, $state, ItemService) {

    $scope.item = {};
    $scope.items = [];

    $scope.getItems = function () {
        ItemService.getItems(function (response) {
            $scope.items = response.data;
        }, function (response) {
            console.log("an error occured while trying to fetch list of items");
        });
    };

    $scope.createItem = function () {
        Pace.restart();
        ItemService.createItem($scope.item, function(response) {
            console.log("item was successfully created");
            $state.go('view-items');
        }, function (response) {
            console.log("item could not be created");
        });
    };

    $scope.deleteItem = function (itemId) {
        ItemService.deleteItem(itemId, function (response) {
            console.log("item was successfully deleted");
            $scope.getItems();
        }, function(response) {
            console.log("an error occured while trying to delete the item");
        });
    };

    $scope.updateItem = function () {
        ItemService.updateItem($scope.itemUpdate.id, $scope.itemUpdate, function(response) {
            console.log("item was successfully updated");
            $scope.getItems();
        }, function (response) {
            console.log("an error occured while trying to update the item");
        });
    };
}]);

app.service('ItemService', ['APIService', function(APIService) {

    this.createItem = function (itemDetails, successHandler, errorHandler) {
        APIService.post('/api/item/create', itemDetails, successHandler, errorHandler);
    };

    this.getItems = function (successHandler, errorHandler) {
        APIService.get('/api/items', successHandler, errorHandler);
    };

    this.getItemById = function (itemId, successHandler, errorHandler) {
        APIService.get('/api/item/' + itemId, successHandler, errorHandler);
    };

    this.deleteItem = function (itemId, successHandler, errorHandler) {
        APIService.delete('/api/item/delete/' + itemId, successHandler, errorHandler);
    };

    this.updateItem = function (itemId, itemDetails, successHandler, errorHandler) {
        APIService.put('/api/item/update/' + itemId, itemDetails, successHandler, errorHandler);
    };
}]);