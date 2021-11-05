@if ($client->type == "corporate")
    <a href="#" class="text-primary fw-bolder  mb-1 fs-6">{{ $client->company->name}}</a>
    <span class="text-muted fw-bold d-block fs-7"> <i class="fas fa-building"></i>{{trans("lang.{$client->type}")}}</span>  
@else
    <span class="text-muted fw-bold d-block fs-7"><i class="fas fa-user-tie"></i>{{trans("lang.{$client->type}")}}</span>  
@endif  
