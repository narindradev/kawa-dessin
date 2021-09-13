@if ($user->client->type == "corporate")
    <a href="#" class="text-primary fw-bolder  mb-1 fs-6">{{ $user->client->company->name}}</a>
    <span class="text-muted fw-bold d-block fs-7"> <i class="fas fa-building"></i>  {{   trans("lang.{$user->client->type}") }}</span>  
@else
    <span class="text-muted fw-bold d-block fs-7"> <i class="fas fa-user-tie"></i></i>  {{   trans("lang.{$user->client->type}") }}</span>  
@endif  
