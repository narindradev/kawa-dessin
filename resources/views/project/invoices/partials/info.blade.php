<table class="table  ">
    <tbody>
        <tr>
            <td style="float: left; border-top: 1px solid white;">
                <table class="table table-bordered" style="width: 200px">
                    <thead style="background-color: #c6b3b5;">
                        <tr>
                            <th>Facture</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> {{ get_array_value($invoice_data ,"invoice_num")}}</td>
                        </tr>

                    </tbody>
                </table>
                <table class="table table-bordered" style="width: 200px">
                    <thead style="background-color: #c6b3b5;">
                        <tr>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{  get_array_value($invoice_data ,"date") }}</td>
                        </tr>
                    </tbody>
                </table>
            </td>

            <td style="float: left; border-top: 1px solid white;">

            </td>
            <td style="float: right; border-top: 1px solid white;">
                <table class="table table-bordered">
                    <thead  align="right" style="background-color: #c6b3b5;">
                        <tr align="right">
                            <th align="right">Client</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td align="right">
                                <span align="right"> {{ $invoice->project->client->user->name }} </span> <br>
                                @if ($invoice->project->client->user->address)
                                    <span  align="right"> 13 rue René Laenec {{ $invoice->project->client->user->address }} </span><br>
                                @endif
                                @if ($invoice->project->client->user->city)
                                    <span align="right">{{ $invoice->project->client->user->city }} {{ $invoice->project->client->user->zip }}  </span><br>
                                @endif
                                @if ($invoice->project->client->user->phone)
                                    <span> Tél : {{ $invoice->project->client->user->phone}} </span><br>
                                @endif
                                <span> Email : {{ $invoice->project->client->user->email }} </span><br>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
