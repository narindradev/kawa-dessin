<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <title>Facture</title>
</head>

<body>
    <style>
        div {
            line-height: normal;
        }
    </style>
    <div>
        <hr>
        @include('project.invoices.partials.header' ,["invoice" => $invoice])
        <hr>
        @include('project.invoices.partials.info',["invoice" => $invoice ,"invoice_data" => $invoice_data])
        @include('project.invoices.partials.table',["invoice" => $invoice])
        @include('project.invoices.partials.footer',["invoice" => $invoice ,"invoice_data" => $invoice_data])
    </div>
</body>

</html>
