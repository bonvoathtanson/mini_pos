<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>បោះពុម្ភ តារាងមុខទំនិញ</title>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" href="{{url('/css/print.css')}}" media="all" title="no title" charset="utf-8">
</head>
<body>
  <div class="container-A4">
    <div class="print-header">
        <div class="font-M1 center" style="font-size:14pt;">ភ្នំពេញខ្សាច់</div>
        <div class="font-M1 center" style="font-size:12pt;">
            តារាងប្រភេទខ្សាច់
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
            <th>លេខកូដ</th>
            <th>ឈ្មោះទំនិញ</th>
            <th class="center">តំលៃលក់</th>
            <th class="center">ចំនួនក្នុងស្តុក</th>
          </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $key => $value): ?>
                <tr>
                    <td>{{$value->ItemCode}}</td>
                    <td>{{$value->ItemName}}</td>
                    <td class="center">{{$value->SalePrice}}</td>
                    <td class="center">{{$value->UnitInStock}}</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="print-footer">

    </div>
  </div>
</body>
</html>
