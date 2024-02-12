@foreach($organisationTypes as $type)
    <li class="nav-item">
        <a class="nav-link menu-link collapsed"
           href="#orgType{{ $type->id }}_{{ $parentOrganisation->id }}"
           data-bs-toggle="collapse" role="button" aria-expanded="false"
           aria-controls="orgType{{ $type->id }}_{{ $parentOrganisation->id }}"
           style="font-weight: bolder;">
            {{ $type->name }}
        </a>
        <div class="collapse menu-dropdown" id="orgType{{ $type->id }}_{{ $parentOrganisation->id }}">
            <ul class="nav nav-sm flex-column no-bullet">
                @foreach($type->organisations->where('organisation_id', $parentOrganisation->id) as $childOrganisation)
                    <li class="nav-item">
                        <a class="nav-link menu-link collapsed"
                           href="#childOrg{{ $childOrganisation->id }}"
                           data-bs-toggle="collapse" role="button" aria-expanded="false"
                           aria-controls="childOrg{{ $childOrganisation->id }}">
                            {{ $childOrganisation->name }}
                        </a>
                        <div class="collapse menu-dropdown" id="childOrg{{ $childOrganisation->id }}">
                            <ul class="nav nav-sm flex-column no-bullet">
                                <!-- Check if the organisation has child types and include them recursively -->
                                @if($childOrganisation->organisationType && $childOrganisation->organisationType->children->isNotEmpty())
                                    @include('components.organisation-type-tree', [
                                        'organisationTypes' => $childOrganisation->organisationType->children,
                                        'parentOrganisation' => $childOrganisation
                                    ])
                                @endif
                            </ul>
                        </div>
                    </li>
                @endforeach
                <li class="nav-item">
                    <a href="{{ route('organisation.organisations.index', [$organisation->slug, $type->slug,$parentOrganisation->slug]) }}" class="nav-link">Add New {{ $type->name }}</a>
                </li>
            </ul>
        </div>
    </li>
@endforeach
