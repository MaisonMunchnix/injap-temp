<html>

<head>
    <style>
        table {
            width: 100%;
            padding: 0px !important;
            margin-bottom: 12px !important;
            border: 1px dashed black;
        }

        img {
            width: 100px;
        }

        /*tr,td{
			border: 1px solid black;
			padding: 0;
		}*/

        .text-center {
            text-align: center;
        }

        /*td{
			border: 1px solid gray;
		}*/

    </style>
</head>

<body>
    @foreach($product_codes as $product_code)
    <table>
        <tbody>
            <tr style="padding:0 !important; margin:0 !important;">
                <td rowspan="4" style="width:100px !important; padding:0 !important; margin:0 !important;">
                    <img style="padding:0 !important; margin:0 !important;" class="text-center" src="data:image/png;base64,{{DNS2D::getBarcodePNG($product_code->code, 'QRCODE',10,10,array(1,1,1), true)}}" alt="barcode">
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Company Name</strong>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Product Code:</strong> {{ $product_code->code }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>PIN:</strong> {{ $product_code->security_pin }}
                </td>
            </tr>
        </tbody>
    </table>
    @endforeach
</body>

</html>
