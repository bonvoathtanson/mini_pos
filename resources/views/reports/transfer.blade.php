<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>បោះពុម្ភ ទំនិញដែលត្រូវដឹកចេញ</title>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" href="{{url('/css/print.css')}}" media="all" title="no title" charset="utf-8">
</head>
</head>
<body>
  <div class="container-A4">
    <div class="print-header">
        <div class="font-M1 center" style="font-size:14pt;">ភ្នំពេញខ្សាច់</div>
        <div class="font-M1 center" style="font-size:12pt;">
            តារាងទំនិញដែលត្រូវដឹកចេញ
        </div>
        <div class="font-HA center" style="font-size:11pt;">
            អាស័យដ្ឋានៈ វិថីស៊ីសុវិត្ថិ សង្កាត់ស្រះចក ខណ្ឌដូនពេញ រាជធានីភ្នំពេញ
        </div>
        <div class="font-HA center" style="font-size:11pt;">
            លេខទូរស័ព្ទៈ ០១៧​ ៨៦ ៨៨ ៦៧
        </div>
    </div>
    <div class="print-body">
    <table class="table table-bordered" style="width:100%;">
        <thead>
            <tr class="warning font-M1">
                <th>ល.រ</th>
                <th>ឈ្មោះទំនិញ</th>
                <th class="center">ចំនួន</th>
                <th class="center">តំលៃរាយ</th>
                <th class="center">តំលៃសរុប</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="center">1</td>
                <td>{{$transfer->Item->ItemName}}</td>
                <td class="center">{{$transfer->Quantity}}</td>
                <td class="center">{{$transfer->SalePrice}}</td>
                <td class="center">{{$transfer->Quantity * $transfer->SalePrice}}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align:right;border-right:solid 1px;border-left:solid 1px white;border-bottom:solid 1px white;">សរុប </td>
                <td class="center">
                    <span id="remain" style=" font-weight:bold;">{{$transfer->Quantity * $transfer->SalePrice}}</span>
                </td>
            </tr>
        </tfoot>
    </table>
    </div>
    <div class="print-footer">

    </div>
  </div>
</body>
</html>
