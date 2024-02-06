@php
use App\Http\Controllers\BranchesController;
@endphp
@php     
$branchdata = BranchesController::get_branch_data(auth()->user()->branch_id);
// dd($branchdata)
@endphp
<div id="print_receipt" style="display: none">


<div class="rec_container" id="print_area" >

<div class="receipt_header">
<h1>{{ $branchdata->branch_code }} {{ $branchdata->branch_name }}</h1>
<h2>{{ $branchdata->branch_address }}</h2>
</div>

<div class="receipt_body" id="receipt_data">

   
    </div>


</div>
<div class="row center text-center">

<button id="basic" style="display:none" class="btn btn-shadow btn-primary"><i class="fas fa-print"></i> Print</button>

 

</div>
</div>
<style>
  .rec_container {
display: block;
width: 100%;
background: #fff;
max-width: 350px;
padding: 5px;
margin: 5px auto 0;
box-shadow: 0 3px 10px rgb(0 0 0 / 0.2);
}

#print_area .receipt_header {
padding-bottom: 10px;
border-bottom: 1px dashed #000;
text-align: center;
}

#print_area .receipt_header h1 {
font-size: 20px;
margin-bottom: 5px;
text-transform: uppercase;
}

#print_area .receipt_header h1 span {
display: block;
font-size: 25px;
}

#print_area .receipt_header h2 {
font-size: 14px;
color: #727070;
font-weight: 300;
}

#print_area .receipt_header h2 span {
display: block;
}

#print_area .receipt_body {
margin-top: 25px;
}

#print_area table {
width: 100%;
}

#print_area thead, tfoot {
position: relative;
}

#print_area thead th:not(:last-child) {
text-align: left;
}

#print_area thead th:last-child {
text-align: right;
}

#print_area thead::after {
content: '';
width: 100%;
border-bottom: 1px dashed #000;
display: block;
position: absolute;
}

#print_area tbody td:not(:last-child), tfoot td:not(:last-child) {
text-align: left;
}

#print_area tbody td:last-child, tfoot td:last-child{
text-align: right;
}

#print_area tbody tr:first-child td {
padding-top: 15px;
}

#print_area tbody tr:last-child td {
padding-bottom: 15px;
}

#print_area tfoot tr:first-child td {
padding-top: 15px;
}

#print_area tfoot::before {
content: '';
width: 100%;
border-top: 1px dashed #000;
display: block;
position: absolute;
}

#print_area tfoot tr:first-child td:first-child, tfoot tr:first-child td:last-child {
font-weight: bold;
font-size: 20px;
}

#print_area .date_time_con {
display: flex;
justify-content: center;
column-gap: 25px;
}

#print_area .items {
margin-top: 25px;
}

#print_area h3 {
border-top: 1px dashed #000;
padding-top: 10px;
margin-top: 25px;
text-align: center;
text-transform: uppercase;
}
</style>