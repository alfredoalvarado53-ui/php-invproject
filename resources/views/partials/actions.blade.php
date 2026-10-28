@props(['item', 'showRoute' => null, 'editRoute' => null, "deleteRoute" => null, 'payRoute' => null])
<ul class="site-helpers justify-content-end">
    @if($payRoute && !($item->paid ?? false))
    <li class="site-helpers__items">
        <form action="{{ route($payRoute, $item) }}" method="POST">
            @csrf
            @method("PATCH")
            <button type="submit" class="btn site-helpers__links color-persian-green" title="{{ __('Pažymėti kaip apmokėtą') }}">
                <i class="icon-check" aria-hidden="true"></i>
            </button>
        </form>
    </li>
    @endif
    @if($showRoute)
    <li class="site-helpers__items">
        <a href="{{ route($showRoute, $item) }}" class="btn site-helpers__links color-persian-green"><i class="icon-clipboard" aria-hidden="true"></i></a>
    </li>
    @endif
    @if($editRoute)
    <li class="site-helpers__items">
        <a href="{{ route($editRoute, $item) }}" class="btn site-helpers__links color-yellow-orange"><i class="icon-edit" aria-hidden="true"></i></a>
    </li>
    @endif
    @if($deleteRoute)
    <li class="site-helpers__items">
        <form action="{{ route($deleteRoute, $item) }}" method="POST">
            @csrf
            @method("DELETE")
            <button type="submit" class="btn site-helpers__links color-scarlet"><i class="icon-trash" aria-hidden="true"></i></button>
        </form>
    </li>
    @endif
</ul>
