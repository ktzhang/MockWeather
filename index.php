<!doctype html>
<html ng-app="JSONedit">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <script src="lib/jquery.min.js"></script>
    <script src="lib/jquery-ui/js/jquery-ui.min.js"></script>
    <script src="lib/angular.min.js"></script>
    <script src="lib/angular-ui/angular-ui.js"></script>
    <script src="lib/angular-ui/multiSortable.js"></script>
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <script src="js/directives.js"></script>
    <script src="js/json2.js"></script>
    <script src="js/JSONedit.js"></script>
    <link href="css/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="mainView" ng-controller="MainViewCtrl" ng-init="initData(1)">
        <div class="submitBar">            
            <input name="Submit" value="Submit" type="button" ng-click="postData()" /> 
        </div>
        <h2 class="title">Weather Mock {{dataTypes[dataType]}}</h2>
        <div class="dropdown">
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                     <div class="" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li ng-repeat="(key, value) in dataTypes">
                              <a ng-click="$parent.initData(key)">
                                {{value}}
                              </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="jsonView" defocus>
            <json child="jsonData" type="'object'"></json>
        </div>

        <h3>Text JSON</h3>
        <div>
            <textarea ng-model="jsonString"></textarea>
            <span class="red" ng-if="!wellFormed">JSON not well-formed!</span>
        </div>

    </div>
</body>
</html>
