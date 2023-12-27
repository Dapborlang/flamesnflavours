<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=58mm, initial-scale=1">
    <title>Receipt</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            text-align: center;
        }

        .receipt {
            width: 58mm;
            margin: 0 auto;
            padding: 10px;
            border: 1px solid #000;
            font-size: 10px;
        }

        table {
            width: 98%;
            margin-top: 10px;
            border-collapse: collapse;
        }

        th, td {
            border: 0px solid #000;
        }

        th {
            background-color: #f2f2f2;
        }

        @media print {
            .receipt {
                width: 98%; 
                border: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <span style="font-size: 12px;">Flames & Flavours<br>Phone: 7642906603</span><br>
        Token: {{$id}}
        <hr>
        <table>
            <tbody>
                @foreach($order as $item)
                <tr>
                    <td style="text-align: left;">
                        {{$item->menuItem->name}}<br>                       
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;">
                         {{$item->quantity}}X₹{{$item->menuItem->price}} = ₹{{$item->quantity*$item->menuItem->price}}
                         @php
                         $total_amt[]=$item->quantity*$item->menuItem->price;
                         @endphp
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td style="text-align: right;">
                        Total: ₹{{array_sum($total_amt)}}
                    </td>
                </tr>
            </tbody>
        </table>
        ******Thank you******
        <br>Please visit again.
    </div>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
