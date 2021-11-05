<table class="table">
    <thead>
        <tr>
            <th style="border-color: white;"></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <table class="table  table-sm table-bordered border-secondary">
                    <thead style="background-color: #c6b3b5;">
                        <tr>
                            <th>Date</th>
                            <th>Ref</th>
                            <th>Description</th>
                            <th>PrixUnit</th>
                            <th>Quantité</th>
                            <th>Remise</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($invoice->project->categories as $categorie) --}}
                            <tr>
                                <td>7/12/2020</td>
                                <td></td>
                                <td> {{ $invoice->project->categories->pluck("name")->implode(" , ", "name") }}</td>
                                <td>{{ format_to_currency($invoice->project->price) }}</td>
                                <td>1</td>
                                <td>0</td>
                                <td>{{ format_to_currency($invoice->project->price) }}</td>
                            </tr>
                        {{-- @endforeach --}}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="border-color: white;"></td>
                            <td style="border-color: white;"></td>
                            <td style="border-color: white;"></td>
                            <td style="border-color: white;"></td>
                            <td colspan="2" style="border-left: 2px solid #dee2e6!important;">Montant HTVA</td>
                            <td> {{ get_array_value($invoice_data, 'sub_total') }}</td>
                        </tr>
                        <tr>
                            <td style="border-color: white;"></td>
                            <td style="border-color: white;"></td>
                            <td style="border-color: white;"></td>
                            <td style="border-color: white;"></td>
                            <td colspan="2" style="border-left: 2px solid #dee2e6!important;">TVA
                                ({{ get_array_value($invoice_data, 'taxe_percent') }}%)</td>
                            <td> {{ get_array_value($invoice_data, 'price_of_taxe') }}</td>
                        </tr>
                        <tr>
                            <td style="border-color: white;"></td>
                            <td style="border-color: white;"></td>
                            <td style="border-color: white;"></td>
                            <td style="border-color: white;"></td>
                            <td colspan="2" style="border-left: 2px solid #dee2e6!important;">TTC</td>
                            <td> {{ get_array_value($invoice_data, 'price_with_taxe') }}</td>
                        </tr>
                        <tr>
                            <td style="border-color: white;"></td>
                            <td style="border-color: white;"></td>
                            <td style="border-color: white;"></td>
                            <td style="border-color: white;"></td>
                            <td colspan="2" style="border-left: 2px solid #dee2e6!important;">Acompte 50%</td>
                            <td> {{ get_array_value($invoice_data, '50_50') }}</td>
                        </tr>
                        <tr>
                            <td style="border-color: white;"></td>
                            <td style="border-color: white;"></td>
                            <td style="border-color: white;"></td>
                            <td style="border-color: white;"></td>
                            <td colspan="2" style="border-left: 2px solid #dee2e6!important;">Total déjà payer</td>
                            <td> {{ format_to_currency(get_array_value($invoice_data, 'total_paid')) }}</td>
                        </tr>
                            <tr>
                                <td style="border-color: white;"></td>
                                <td style="border-color: white;"></td>
                                <td style="border-color: white;"></td>
                                <td style="border-color: white;"></td>
                                <td colspan="2" style="border-left: 2px solid #dee2e6!important;">Reste à payer</td>
                                <td> {{ format_to_currency(get_array_value($invoice_data, 'rest_to_paid')) }}</td>
                            </tr>
                       
                    </tfoot>
                </table>
            </td>

        </tr>

    </tbody>
</table>
