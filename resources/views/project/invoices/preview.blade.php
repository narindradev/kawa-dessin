<x-base-layout>
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-header justify-content-end ribbon ribbon-end ribbon-clip">
                    <div class="ribbon-label">
                        {{ trans("lang.{$invoice->status->name}")  }}
                        <span class="ribbon-inner bg-{{$invoice->status->class}}"></span>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="d-flex flex-column flex-xl-row">
                        <div class="flex-lg-row-fluid me-xl-18 mb-10 mb-xl-0">
                            <div class="mt-n1">
                                <div class="d-flex flex-stack pb-10">
                                    <a href="#">
                                        <img alt="Logo" src="/metronic8/demo1/assets/media/svg/brand-logos/code-lab.svg">
                                    </a>
                                </div>
                                <div class="m-0">
                                    <div class="row g-5 mb-11">
                                        <div class="col-6">
                                            <div class="fw-bold fs-7 text-gray-900 mb-1">Facture</div>
                                            <div class="fw-bolder fs-6 text-gray-600 mb-1"> {{ get_array_value($invoice_data ,"invoice_num") }}</div>
                                        </div>
                                       @if ($invoice->status->name != "paid" && $invoice->project->own_project() )
                                        <div class="col-6 text-end">
                                            {!!  modal_anchor(url("/project/invoice/checkout-form/$invoice->id"), '<i class="fas fa-bookmark"></i>  Payer maitenant  ', ["class" => "btn btn-sm  btn-light-primary" ,'title' => 'Paiment' ,  "modal-width" => "mw-1000px"])   !!}
                                        </div>
                                       @endif
                                    </div>
                                    <div class="row g-5 mb-12">
                                        <div class="col-sm-6">
                                            <div class="fw-bold fs-7 text-gray-900 mb-1">Date</div>
                                            <div class="fw-bolder fs-6 text-gray-600 mb-1"> {{ get_array_value($invoice_data ,"date") }} </div>
                                        </div>
                                        <div class="col-sm-6 text-end">
                                            <div class="fw-bold fs-7 text-gray-900 mb-1">Client</div>
                                            <div class="fw-bolder fs-6 text-gray-600"> {{ $invoice->project->client->user->name }} </div>
                                            <div class="fw-bold fs-7 text-gray-600">{{ $invoice->project->client->user->address }} <br>{{ $invoice->project->client->user->city }}  {{ $invoice->project->client->user->zip }}</div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="table-responsive border-bottom mb-9">
                                            <table class="table mb-3 align-middle">
                                                <thead>
                                                    <tr class="border-bottom fs-6 fw-bolder text-muted ">
                                                        <th class="pb-2 text-gray-800 ">Date</th>
                                                        <th class="pb-2 text-gray-800">Réf</th>
                                                        <th class="pb-2 text-gray-800">Description</th>
                                                        <th class="pb-2 text-gray-800">Prix unit</th>
                                                        <th class="pb-2 text-gray-800">Quantité</th>
                                                        <th class="pb-2 text-gray-800">Remise</th>
                                                        <th class="pb-2 text-gray-800 text-end">Montant</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- @foreach ($invoice->project->categories as $categorie) --}}
                                                        <tr class="fw-bolder text-gray-700 fs-5 ">
                                                            <td class="d-flex  pt-6"></i> 12-02-2021 </td>
                                                            <td class="pt-6  fw-bold">-</td>
                                                            <td class="pt-6  fw-bold">{{ ucfirst(strtolower($invoice->project->categories->pluck("name")->implode(" , ", "name"))) }}</td>
                                                            <td class="pt-6  fw-bold"> {{ format_to_currency($invoice->project->price) }}</td>
                                                            <td class="pt-6  fw-bold">1</td>
                                                            <td class="pt-6  fw-bold">{{ format_to_currency(0) }}</td>
                                                            <td class="pt-6  fw-bold text-end"> {{ format_to_currency($invoice->total) }}</td>
                                                        </tr>
                                                    {{-- @endforeach --}}
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <div class="mw-300px">
                                                <div class="d-flex flex-stack mb-3">
                                                    <div class="fw-bold pe-10 text-gray-600 fs-7">Montant HTVA </div>
                                                   
                                                    <div class="text-end fw-bolder fs-6 text-gray-600"> {{ get_array_value($invoice_data ,"sub_total") }}</div>
                                                </div>
                                                <div class="d-flex flex-stack mb-3">
                                                    <div class="fw-bold pe-10 text-gray-600 fs-7">TVA ({{  get_array_value($invoice_data ,"taxe_percent") }}) %</div>
                                                    <div class="text-end fw-bolder fs-6 text-gray-700"> {{ get_array_value($invoice_data ,"price_of_taxe") }}</div>
                                                </div>
                                                <div class="d-flex flex-stack mb-3">
                                                    <div class="fw-bold pe-10 text-gray-600 fs-7">TTC</div>
                                                    <div class="text-end fw-bolder fs-6 text-gray-700">{{ get_array_value($invoice_data ,"price_with_taxe") }} </div>
                                                </div>
                                                <div class="d-flex flex-stack mb-3">
                                                    <div class="fw-bold pe-10 text-gray-600 fs-7">Acompte 50%</div>
                                                    <div class="text-end fw-bolder fs-6 text-gray-700"> {{ get_array_value($invoice_data ,"50_50") }} </div>
                                                </div>
                                                <div class="separator  my-1 mb-2"></div>
                                                <div class="d-flex flex-stack mb-2">
                                                    <div class="fw-bold pe-10 text-gray-900 fs-7">TOTAL</div>
                                                    <div class="text-end fw-bolder fs-6 text-gray-900"> {{ get_array_value($invoice_data ,"price_with_taxe") }} </div>
                                                </div>
                                                <div class="separator  my-1 mt-2"></div>
                                                <div class="d-flex flex-stack mb-3">
                                                    <div class="fw-bold pe-10 text-gray-600 fs-7">Total déjà payer</div>
                                                    <div class="text-end fw-bolder fs-6 text-gray-700"> {{ format_to_currency(get_array_value($invoice_data ,"total_paid")) }} </div>
                                                </div>
                                                @if (get_array_value($invoice_data ,"rest_to_paid"))
                                                    <div class="d-flex flex-stack mb-3">
                                                        <div class="fw-bold pe-10 text-gray-700 fs-7">Reste à payer</div>
                                                        <div class="text-end fw-bolder fs-6 text-gray-700"> {{ format_to_currency(get_array_value($invoice_data ,"rest_to_paid")) }} </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://js.stripe.com/v3" ></script>
</x-base-layout>