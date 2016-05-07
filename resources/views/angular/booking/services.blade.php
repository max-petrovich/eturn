<div class="container" ng-controller="BookingController">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('all.services_list') }}</div>

                <div class="panel-body">
                        <div class="list-group">
                                <li class="list-group-item clearfix" ng-repeat="service in services">
                                    <% service.title %>
                                    <div class="pull-right"><a href="/booking/<% service.id %>" class="btn btn-primary">{{ trans('all.to_book') }} <i class="fa fa-shopping-cart"></i></a></div>
                                </li>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>