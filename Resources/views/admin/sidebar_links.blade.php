@php use App\Helpers\WebsiteHelper;use Illuminate\Http\Request; @endphp
<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="retailObjectsRestaurant" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseRetailObjectsRestaurant" aria-expanded="false" aria-controls="collapseRetailObjectsRestaurant">
        <h4 class="panel-title">
            <a>
                <i class="far fa-list-alt"></i> <span>{{ __('retailobjectsrestourant::admin.restaurants.index') }}</span>
            </a>
        </h4>
    </div>
    <div id="collapseRetailObjectsRestaurant" class="panel-collapse collapse" role="tabpanel" aria-labelledby="retailObjectsRestaurant">
        <div class="panel-body">
            <ul class="nav">
                <li><a href="{{ route('admin.retail-objects-restaurants.index') }}" class="{{ WebsiteHelper::isActiveRoute('admin.retail-objects-restaurants.*') ? 'active' : '' }}"><i class="fas fa-copyright"></i> <span>{{ __('retailobjectsrestourant::admin.retail_object') }}</span></a></li>
                <li><a href="{{ route('admin.retail-objects-restaurants.settings.index') }}" class="{{ WebsiteHelper::isActiveRoute('admin.retail-objects-restaurants.settings.*') ? 'active' : '' }}"><i class="fas fa-cogs"></i> <span>{{ __('retailobjectsrestourant::admin.settings.index') }}</span></a></li>
            </ul>
        </div>
    </div>
</div>
