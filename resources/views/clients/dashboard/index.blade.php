<x-base-layout>

    <div class="row gy-5 g-xl-8">
        <div class="col-xxl-4">
            {{ theme()->getView('partials/widgets/mixed/_widget-2', array('class' => 'card-xxl-stretch', 'chartCcolor' => 'danger', 'chartHeight' => '200px')) }}
        </div>
        <div class="col-xxl-4">
            {{ theme()->getView('partials/widgets/lists/_widget-5', array('class' => 'card-xxl-stretch')) }}
        </div>
        <div class="col-xxl-4">
            {{ theme()->getView('partials/widgets/mixed/_widget-7', array('class' => 'card-xxl-stretch-50 mb-5 mb-xl-8', 'chartCcolor' => 'primary', 'chartHeight' => '150px')) }}

            {{ theme()->getView('partials/widgets/mixed/_widget-10', array('class' => 'card-xxl-stretch-50 mb-5 mb-xl-8', 'chartCcolor' => 'primary', 'chartHeight' => '175px')) }}
        </div>
    </div>
    <div class="row gy-5 gx-xl-12">
        <div class="col-xl-12">
            @include('clients.widgets.project')
        </div>
    </div>
</x-base-layout>
