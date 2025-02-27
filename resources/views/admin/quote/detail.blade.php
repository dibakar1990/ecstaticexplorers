<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quote</title> 
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        } 
        .table-title {
            padding: 6px;
            text-align: center;
            font-weight: bold;
        }
        .table-text {
            padding: 6px;
            text-align: center;
        } 
    </style> 
</head>    
<body>
    <div style="text-align: center;">
        <img src="{{ asset('admin/assets/images/logo.png') }}"> 
        <h2 style="margin-top: 0;">Ecstatic Explorers</h2>
    </div>  
    <br><br>
    <table> 
        <tr>
            <th class="table-title">Invoice Number</th>
            <th class="table-title">Place of Supply</th>
            <th class="table-title">Transaction Category</th>
            <th class="table-title">Date</th>
            <th class="table-title">Transaction Type</th>
            <th class="table-title">Document Type</th>
        </tr>
        <tr>
            <td class="table-text">{{ $quote->invoice_number }}</td>
            <td class="table-text">{{ $quote->place_of_supply }}</td>
            <td class="table-text">{{ $quote->transaction_category }}</td>
            <td class="table-text">{{ $quote->date }}</td>
            <td class="table-text">{{ $quote->transaction_type }}</td>
            <td class="table-text">{{ $quote->document_type }}</td> 
        </tr>  
    </table> 
    <br><br>
    <table> 
        <tr>
            <td class="table-title">Location</td>
            <td class="table-text">{{ $quote->location }}</td> 
        </tr>  
        <tr>
            <td class="table-title">Customer Name</td>
            <td class="table-text">{{ $quote->customer_name }}</td> 
        </tr> 
        <tr>
            <td class="table-title">Travel Date</td>
            <td class="table-text">{{ $quote->travel_date }}</td> 
        </tr>
        <tr>
            <td class="table-title">Customer Contact Number</td>
            <td class="table-text">{{ $quote->customer_contact_number }}</td> 
        </tr>
        <tr>
            <td class="table-title">Total Pax</td>
            <td class="table-text">{{ $quote->total_pax }}</td> 
        </tr>
        <tr>
            <td class="table-title">Number of Adults</td>
            <td class="table-text">{{ $quote->number_of_adult }}</td> 
        </tr>
        <tr>
            <td class="table-title">Number of Children (5 to 10 yrs)</td>
            <td class="table-text">{{ $quote->number_of_children }}</td> 
        </tr>
        <tr>
            <td class="table-title">Number of Infants (0 to 5 yrs)</td>
            <td class="table-text">{{ $quote->number_of_infant }}</td> 
        </tr>
        <tr>
            <td class="table-title">Pick up Point</td>
            <td class="table-text">{{ $quote->pick_up_point }}</td> 
        </tr>
        <tr>
            <td class="table-title">Drop Point</td>
            <td class="table-text">{{ $quote->drop_point }}</td> 
        </tr>
        <tr>
            <td class="table-title">Transportation</td>
            <td class="table-text">{{ $quote->transportation }}</td> 
        </tr>
        <tr>
            <td class="table-title">No. Of Room</td>
            <td class="table-text">{{ $quote->no_of_room }}</td> 
        </tr>
        <tr>
            <td class="table-title">Meal Plan</td>
            <td class="table-text">{{ $quote->meal_plan }}</td> 
        </tr>  
    </table> 
    <br><br>
    <h4 style="font-weight: 600; margin-bottom: 0;">Ecstatic Explorers</h4> 
    <small>
        Premises no. D-206, Mondalganthi, Kaikhali, Kolkata – 700052
        <br>
        Contact Number: +918910845933/+919836155825
        <br>
        Website: https://www.ecstaticexplorers.com
        <br>
        Email: explore@ecstaticexplorers.com
        <br>
        PAN: AAKFE3792M
        <br>
        Certificate No: 0917P29092396654
    </small>. 
    <br><br>
    <h2>Accommodation Details</h2> 
    {!! $quote->accommodation !!}  
    <br><br>
    <h4 style="font-weight: 600; margin-bottom: 0;">Ecstatic Explorers</h4> 
    <small>
        Premises no. D-206, Mondalganthi, Kaikhali, Kolkata – 700052
        <br>
        Contact Number: +918910845933/+919836155825
        <br>
        Website: https://www.ecstaticexplorers.com
        <br>
        Email: explore@ecstaticexplorers.com
        <br>
        PAN: AAKFE3792M
        <br>
        Certificate No: 0917P29092396654
    </small>. 
    <br><br>
    <h2>Cost Breakup</h2> 
    {!! $quote->cost_breakup !!} 
    <br><br>
    <h4 style="font-weight: 600; margin-bottom: 0;">Ecstatic Explorers</h4> 
    <small>
        Premises no. D-206, Mondalganthi, Kaikhali, Kolkata – 700052
        <br>
        Contact Number: +918910845933/+919836155825
        <br>
        Website: https://www.ecstaticexplorers.com
        <br>
        Email: explore@ecstaticexplorers.com
        <br>
        PAN: AAKFE3792M
        <br>
        Certificate No: 0917P29092396654
    </small>. 
    <br><br>
    <h2>Detailed Itinerary</h2>
    {!! $quote->itinerary !!}  
    <br><br>
    <h4 style="font-weight: 600; margin-bottom: 0;">Ecstatic Explorers</h4> 
    <small>
        Premises no. D-206, Mondalganthi, Kaikhali, Kolkata – 700052
        <br>
        Contact Number: +918910845933/+919836155825
        <br>
        Website: https://www.ecstaticexplorers.com
        <br>
        Email: explore@ecstaticexplorers.com
        <br>
        PAN: AAKFE3792M
        <br>
        Certificate No: 0917P29092396654
    </small>. 
    <br><br>
    <h2>Package Inclusions</h2>
    {!! $quote->package_inclusion !!}  
    <br><br>
    <h4 style="font-weight: 600; margin-bottom: 0;">Ecstatic Explorers</h4> 
    <small>
        Premises no. D-206, Mondalganthi, Kaikhali, Kolkata – 700052
        <br>
        Contact Number: +918910845933/+919836155825
        <br>
        Website: https://www.ecstaticexplorers.com
        <br>
        Email: explore@ecstaticexplorers.com
        <br>
        PAN: AAKFE3792M
        <br>
        Certificate No: 0917P29092396654
    </small>. 
    <br><br>
    <h2>Package Exclusions</h2>
    {!! $quote->package_exclusion !!} 
    <br><br>
    <h4 style="font-weight: 600; margin-bottom: 0;">Ecstatic Explorers</h4> 
    <small>
        Premises no. D-206, Mondalganthi, Kaikhali, Kolkata – 700052
        <br>
        Contact Number: +918910845933/+919836155825
        <br>
        Website: https://www.ecstaticexplorers.com
        <br>
        Email: explore@ecstaticexplorers.com
        <br>
        PAN: AAKFE3792M
        <br>
        Certificate No: 0917P29092396654
    </small>. 
    <br><br>
    <h2>Mode of Payment</h2>
    {!! $quote->mode_of_payment !!}  
    <br><br>
    <h4 style="font-weight: 600; margin-bottom: 0;">Ecstatic Explorers</h4> 
    <small>
        Premises no. D-206, Mondalganthi, Kaikhali, Kolkata – 700052
        <br>
        Contact Number: +918910845933/+919836155825
        <br>
        Website: https://www.ecstaticexplorers.com
        <br>
        Email: explore@ecstaticexplorers.com
        <br>
        PAN: AAKFE3792M
        <br>
        Certificate No: 0917P29092396654
    </small>. 
    <br><br>
    <h2>Terms & Conditions</h2>
    {!! $quote->term_condition !!}  
    <br><br>
    <h4 style="font-weight: 600; margin-bottom: 0;">Ecstatic Explorers</h4> 
    <small>
        Premises no. D-206, Mondalganthi, Kaikhali, Kolkata – 700052
        <br>
        Contact Number: +918910845933/+919836155825
        <br>
        Website: https://www.ecstaticexplorers.com
        <br>
        Email: explore@ecstaticexplorers.com
        <br>
        PAN: AAKFE3792M
        <br>
        Certificate No: 0917P29092396654
    </small>. 
    <br><br> 
    <h2>Cancellation Policy</h2>
    {!! $quote->cancellation_policy !!} 
    <br><br>
    <h4 style="font-weight: 600; margin-bottom: 0;">Ecstatic Explorers</h4> 
    <small>
        Premises no. D-206, Mondalganthi, Kaikhali, Kolkata – 700052
        <br>
        Contact Number: +918910845933/+919836155825
        <br>
        Website: https://www.ecstaticexplorers.com
        <br>
        Email: explore@ecstaticexplorers.com
        <br>
        PAN: AAKFE3792M
        <br>
        Certificate No: 0917P29092396654
    </small> 
</body>    
</html> 
<script type="text/javascript">
    setTimeout(function () { 
        window.print(); 
    }, 500);   
    window.onfocus = function () { 
        window.close(); 
    }  
</script> 