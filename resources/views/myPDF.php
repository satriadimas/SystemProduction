
<!DOCTYPE html>
<html>
<head>
    <title>PO-SDI</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
</head>
<style lang="css">
    *, ::after, ::before {
        box-sizing: border-box;
    }
    .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
        margin-bottom: 0.5rem;
        font-weight: 500;
        line-height: 1.2;
    }
    body {
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        text-align: left;
        background-color: #fff;
    }
    .row {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -10px;
        margin-left: -10px;
    }

    .col {
        -ms-flex-preferred-size: 0;
        flex-basis: 0;
        -ms-flex-positive: 1;
        flex-grow: 1;
        max-width: 100%;
    }

    .col-4 {
        -ms-flex: 0 0 33.333333%;
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
    }

    .col-5 {
        -ms-flex: 0 0 45.83333333333333%;
        flex: 0 0 45.83333333333333%;
        max-width: 45.83333333333333%;
    }

    .col-6 {
        -ms-flex: 0 0 54.16666666666667%;
        flex: 0 0 54.16666666666667%;
        max-width: 54.16666666666667%;
    }

    .col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
        position: relative;
        width: 100%;
        padding-right: 10px;
        padding-left: 10px;
    }

    .mt-5 {
        margin-top: 3rem!important;
    }

    .mt-3 {
        margin-top: 1rem!important;
    }

    .mt-2 {
        margin-top: 0.5rem!important;
    }

    .table-bordered {
        border: 1px solid #dee2e6;
    }
    
    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
    }
    
    .table-bordered {
        border: 1px solid #dee2e6;
    }
    
    .table-bordered td, .table-bordered th {
        border: 1px solid #dee2e6;
    }

    .p-2 {
        padding: 0.5rem!important;
    }

    .pt-2 {
        padding-top: 0.5rem!important;
    }

    .pl-2 {
        padding-left: 0.5rem!important;
    }

    .pr-2 {
        padding-left: 0.5rem!important;
    }

    .px-0 {
        padding-left: 0px!important;
        padding-right: 0px!important;
    }

    .mr-2 {
        margin-right: 0.5rem!important;
    }

    .border-dark {
        border-color: #343a40!important;
    }

    .border {
        border: 1px solid #dee2e6!important;
    }

    .text-center {
        text-align: center;
    }
</style>
<body class="px-10">
    <h3>PT. SHINDENGEN INDONESIA</h3>
    <div class="h5">Kawasan GIIC Blok AD No.2, Deltamas, Nagasari, Serang Baru, Bekasi Regency, West Java 17330</div>
    <div class="h6">Tel : (021) 22157080 &nbsp;&nbsp;&nbsp; Fax : (021) 22157068</div>

    <table class="table mt-5">
        <tr>
            <td class="border border-dark p-2">
                <div>Supplier Name : &nbsp;&nbsp;&nbsp; <?= $data['po'][0]['name'] ?></div>
                <div>Address : &nbsp;&nbsp;&nbsp; <?= $data['po'][0]['address'] ?></div>
            </td>
            <td>
                <div class="border border-dark h5 p-2">PURCHASE ORDER</div>
                <div class="border border-dark p-2">
                    <div>Order No: <?= $data['po'][0]['code'] ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Order Date: <?= $data['date'] ?></div>
                </div>
                <div class="border border-dark mt-2 p-2">Payment Term: <?= $data['po'][0]['terms'] ?></div>
            </td>
        </tr>
</table>
  
    <table class="table table-bordered mt-3">
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Delivery Date</th>
            <th>Quantity</th>
            <th>U/M</th>
            <th>Unit/Price (<?= $data['po'][0]['currency']?>)</th>
            <th>Amount (<?= $data['po'][0]['currency']?>)</th>
        </tr>
        <?php 
            $num = 1; $total = 0; 
            $symbol = '$';
            
            if ($data['po'][0]['currency'] == 'USD') {
                $symbol = '$';
            } elseif($data['po'][0]['currency'] == 'IDR') {
                $symbol = 'Rp.';
            } else {
                $symbol = '¥';
            }
            

        ?>
        <?php foreach ($data['datas'] as $key => $val) { ?>
        <tr>
            <td><?= $num ?></td>
            <td><?= $val['name'] ?></td>
            <td><?= $val['delivery_date'] ?></td>
            <td><?= $val['qty'] ?></td>
            <td><?= $val['unit'] ?></td>
            <td><?= $symbol ?><?= number_format($val['price'], 2, '.', ',') ?></td>
            <td><?= $symbol ?><?= number_format($val['price'] * $val['qty'], 2, '.', ',') ?></td>
        </tr>
        <?php $num++; ?>
        <?php $total += $val['price'] * $val['qty']; ?>
        <?php } ?>
        <?php if (count($data['datas']) !=0) {?>
        <tr>
            <td colspan="6" class="text-center">
                Total Harga
            </td>
            <td colspan="1">
                <?= $symbol ?><?= number_format($total, 2, '.', ',') ?>
            </td>
        </tr>
        <?php } ?>
    </table>
  
</body>
</html>